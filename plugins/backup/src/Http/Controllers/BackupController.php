<?php namespace WebEd\Plugins\Backup\Http\Controllers;

use WebEd\Base\Core\Http\Controllers\BaseAdminController;
use WebEd\Base\Core\Support\DataTable\DataTables;
use Storage;

class BackupController extends BaseAdminController
{
    protected $module = 'webed-backup';

    public function __construct()
    {
        parent::__construct();

        $this->getDashboardMenu($this->module);
    }

    public function getIndex()
    {
        $this->assets->addJavascripts('jquery-datatables');

        $this->setPageTitle('Backups');

        $this->dis['dataTableColumns'] = [
            'headings' => [
                ['name' => 'Type', 'width' => '20%'],
                ['name' => 'Backup size', 'width' => '20%'],
                ['name' => 'Created at', 'width' => '20%'],
                ['name' => 'Actions', 'width' => '20%'],
            ],
        ];

        $this->dis['dataTableHeadings'] = json_encode([
            ['data' => 'type', 'name' => 'type'],
            ['data' => 'file_size', 'name' => 'file_size'],
            ['data' => 'created_at', 'name' => 'created_at', 'searchable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ]);

        return do_filter('webed-backup.index.get', $this)->viewAdmin('index');
    }

    public function postListing(DataTables $dataTables)
    {
        $data = $dataTables
            ->of(collect(\Backup::all()))
            ->addColumn('type', function ($item) {
                $fileName = array_get($item, 'file_name');
                $type = explode('-', $fileName);
                return $type[0];
            })
            ->addColumn('file_size', function ($item) {
                return format_file_size(array_get($item, 'file_size', 0), 2);
            })
            ->addColumn('created_at', function ($item) {
                return convert_unix_time_format(array_get($item, 'last_modified'));
            })
            ->addColumn('actions', function ($item) {
                $download = html()->link(route('admin::webed-backup.download.get', [
                    'path' => array_get($item, 'file_path')
                ]), 'Download', [
                    'class' => 'btn btn-outline green btn-sm ajax-link',
                ]);
                $deleteBtn = form()->button('Delete', [
                    'title' => 'Delete this item',
                    'data-ajax' => route('admin::webed-backup.delete.delete', [
                        'path' => array_get($item, 'file_path')
                    ]),
                    'data-method' => 'DELETE',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]);

                return $download . $deleteBtn;
            });
        return do_filter('datatables.custom-fields.index.post', $data, $this)
            ->make(true);
    }

    /**
     * @param null $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getCreate($type = null)
    {
        try {
            ini_set('max_execution_time', 3000);

            \Backup::createBackupFolder('webed-backup');

            if($type === null || $type === 'database') {
                \Backup::backupDb();
            }
            if($type === null || $type === 'medias') {
                \Backup::backupFolder(public_path('uploads'));
            }

            $this->flashMessagesHelper->addMessages('Completed', 'success');
        } catch (\Exception $exception) {
            $this->flashMessagesHelper->addMessages($exception->getMessage(), 'danger');
        }
        $this->flashMessagesHelper->showMessagesOnSession();
        return redirect()->to(route('admin::webed-backup.index.get'));
    }

    public function getDownload()
    {
        $path = $this->request->get('path');
        $result = \Backup::download($path);
        if ($result !== null) {
            return $result;
        }
        $this->flashMessagesHelper->addMessages('Cannot download...', 'danger')
            ->showMessagesOnSession();
        return redirect()->to(route('admin::webed-backup.index.get'));
    }

    public function deleteDelete()
    {
        $path = $this->request->get('path');
        if (!$path) {
            return response_with_messages('Wrong path name', true, ERROR_CODE);
        }

        $result = \Backup::delete($path);
        if ($result) {
            return response_with_messages('Deleted', false, SUCCESS_NO_CONTENT_CODE);
        }
        return response_with_messages('Cannot delete...', true, ERROR_CODE);
    }

    public function getDeleteAll()
    {
        $result = \Backup::delete();
        if ($result) {
            $this->flashMessagesHelper->addMessages('Deleted', 'success');
        } else {
            $this->flashMessagesHelper->addMessages('Error occurred', 'danger');
        }
        $this->flashMessagesHelper->showMessagesOnSession();
        return redirect()->to(route('admin::webed-backup.index.get'));
    }
}
