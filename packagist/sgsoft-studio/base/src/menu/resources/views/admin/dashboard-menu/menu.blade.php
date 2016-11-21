<?php
/**
 * @var \Illuminate\Support\Collection $links
 */
?>
@forelse($links as $key => $link)
    @if(isset($link['heading']) && $link['heading'] && !$isChildren)
        <li class="header">{{ $link['heading'] or '' }}</li>
    @endif
    <?php
    $hasChildren = ($link['children']->count()) ? true : false;
    ?>
    <li class="treeview {{ $hasChildren ? 'menu-item-has-children' : '' }} {{ (in_array($link['id'], $active)) ? 'active open' : '' }}"
        data-id="{{ $link['id'] or '' }}" data-piority="{{ $link['piority'] or '' }}">
        <a href="{{ $link['link'] or '' }}" class="nav-link {{ $hasChildren ? 'nav-toggle' : '' }}">
            <i class="{{ isset($link['font_icon']) && $link['font_icon'] ? $link['font_icon'] . ' ion' : '' }}"></i>
            <span class="title">{{ $link['title'] or '' }}</span>
            @if($hasChildren)
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            @endif
        </a>
        @if($hasChildren)
            <ul class="sub-menu treeview-menu">
                @include('webed-menu::admin.dashboard-menu.menu', [
                    'links' => $link['children'],
                    'isChildren' => true,
                    'level' => ($level + 1),
                    'active' => $active,
                ])
            </ul>
        @endif
    </li>
@empty

@endforelse
