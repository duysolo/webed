var WebEdIDE = function () {
    /**
     * Current edited file
     */
    var currentFile;

    var currentEditorContent;

    var OPTIONS;

    var initEditor = function () {
        var editor = ace.edit('editor');
        editor.setTheme(OPTIONS.theme || 'ace/theme/monokai');

        editor.getSession().setOptions({
            enableBasicAutocompletion: true,
            enableSnippets: true,
            enableLiveAutocompletion: true,
            enableEmmet: true
        });

        editor.commands.addCommand({
            name: 'save',
            bindKey: {win: 'Ctrl-s', mac: 'Command-s'},
            exec: function (editor) {
                var editorContent = editor.getValue();
                if (editorContent === currentEditorContent) {
                    window.parent.WebEd.showNotification('Nothing changed', 'warning', {
                        life: 2000
                    });
                } else {
                    $.post(OPTIONS.saveUrl, {file: currentFile, contents: editorContent}, function (data) {
                        currentEditorContent = editorContent;
                        window.parent.WebEd.showNotification(data.messages, data.error ? 'danger' : 'success', {
                            life: 2000
                        });
                    });
                }
            },
            readOnly: false
        });

        editor.commands.addCommand({
            name: 'close',
            bindKey: {win: 'Ctrl-d', mac: 'Command-d'},
            exec: function (editor) {
                currentFile = null;
                editor.setValue('');
            },
            readOnly: false
        });
    };

    var initFilesTree = function () {
        var editor = ace.edit('editor');

        $('#tree')
            .jstree({
                'core': {
                    'data': {
                        'url': OPTIONS.getFileUrl + '?operation=get_node',
                        'data': function (node) {
                            return {'id': node.id};
                        }
                    },
                    'check_callback': function (o, n, p, i, m) {
                        if (m && m.dnd && m.pos !== 'i') {
                            return false;
                        }
                        if (o === "move_node" || o === "copy_node") {
                            if (this.get_node(n).parent === this.get_node(p).id) {
                                return false;
                            }
                        }
                        return true;
                    },
                    'themes': {
                        'name': 'default-dark',
                        'responsive': false,
                        'stripes': false,
                        'dots': false,
                        'icons': true
                    }
                },
                'sort': function (a, b) {
                    return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
                },
                'contextmenu': {
                    'items': function (node) {
                        var tmp = $.jstree.defaults.contextmenu.items();
                        delete tmp.create.action;
                        tmp.create.label = "New";
                        tmp.create.submenu = {
                            "create_folder": {
                                "separator_after": true,
                                "label": "Folder",
                                "action": function (data) {
                                    var inst = $.jstree.reference(data.reference),
                                        obj = inst.get_node(data.reference);
                                    inst.create_node(obj, {type: "default"}, "last", function (new_node) {
                                        setTimeout(function () {
                                            inst.edit(new_node);
                                        }, 0);
                                    });
                                }
                            },
                            "create_file": {
                                "label": "File",
                                "action": function (data) {
                                    var inst = $.jstree.reference(data.reference),
                                        obj = inst.get_node(data.reference);
                                    inst.create_node(obj, {type: "file"}, "last", function (new_node) {
                                        setTimeout(function () {
                                            inst.edit(new_node);
                                        }, 0);
                                    });
                                }
                            }
                        };
                        if (this.get_type(node) === "file") {
                            delete tmp.create;
                        }
                        return tmp;
                    }
                },
                'types': {
                    'default': {'icon': 'folder'},
                    'file': {'valid_children': [], 'icon': 'file'}
                },
                'unique': {
                    'duplicate': function (name, counter) {
                        return name + ' ' + counter;
                    }
                },
                'plugins': ['state', 'dnd', 'sort', 'types', 'contextmenu', 'unique', 'wholerow', 'search']
            })
            .on('delete_node.jstree', function (e, data) {
                $.get(OPTIONS.getFileUrl, {
                    'operation': 'delete_node',
                    'id': data.node.id
                })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('create_node.jstree', function (e, data) {
                $.get(OPTIONS.getFileUrl, {
                    'operation': 'create_node',
                    'type': data.node.type,
                    'id': data.node.parent,
                    'text': data.node.text
                })
                    .done(function (d) {
                        data.instance.set_id(data.node, d.id);
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('rename_node.jstree', function (e, data) {
                $.get(OPTIONS.getFileUrl, {
                    'operation': 'rename_node',
                    'id': data.node.id,
                    'text': data.text
                })
                    .done(function (d) {
                        data.instance.set_id(data.node, d.id);
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('move_node.jstree', function (e, data) {
                $.get(OPTIONS.getFileUrl, {
                    'operation': 'move_node',
                    'id': data.node.id,
                    'parent': data.parent
                })
                    .done(function (d) {
                        data.instance.refresh();
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('copy_node.jstree', function (e, data) {
                $.get(OPTIONS.getFileUrl, {
                    'operation': 'copy_node',
                    'id': data.original.id,
                    'parent': data.parent
                })
                    .done(function (d) {
                        data.instance.refresh();
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('changed.jstree', function (e, data) {
                if (data && data.selected && data.selected.length) {
                    $.get(OPTIONS.getFileUrl, {
                        'operation': 'get_content',
                        'id': data.selected.join(':')
                    }, function (d) {
                        if (d && typeof d.type !== 'undefined') {
                            switch (d.type) {
                                case 'md':
                                    editor.getSession().setMode("ace/mode/markdown");
                                    break;
                                case 'yml':
                                    editor.getSession().setMode("ace/mode/yml");
                                    break;
                                case 'sql':
                                    editor.getSession().setMode("ace/mode/sql");
                                    break;
                                case 'php':
                                    editor.getSession().setMode("ace/mode/php");
                                    break;
                                case 'js':
                                    editor.getSession().setMode("ace/mode/javascript");
                                    break;
                                case 'json':
                                    editor.getSession().setMode("ace/mode/json");
                                    break;
                                case 'css':
                                    editor.getSession().setMode("ace/mode/css");
                                    break;
                                case 'html':
                                    editor.getSession().setMode("ace/mode/html");
                                    break;
                                case 'xml':
                                    editor.getSession().setMode("ace/mode/xml");
                                    break;
                                case 'htaccess':
                                case 'log':
                                case 'text':
                                case 'txt':
                                default:
                                    editor.getSession().setMode("ace/mode/text");
                                    break;
                            }
                            editor.setValue(d.content);
                            editor.gotoLine(0);
                            editor.focus();
                            currentFile = data.node.id;
                            currentEditorContent = d.content;
                        }
                    });
                }
            });
    };

    return {
        init: function (options) {
            OPTIONS = options;

            initEditor();
            initFilesTree();
        }
    }
}();
