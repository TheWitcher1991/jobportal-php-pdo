<?php

namespace Core;

class Pagination {

    public function table_ajax($page, $countAll, $limit) {
        $back = '';
        $forward = '';
        $page_left = '';
        $page_right = '';
        $start_page = '';
        $end_page = '';

        $countPages = ceil($countAll / $limit);
        $mid_size = 2;

        if ($page > 1) {
            $back = '<div data-page="'.($page - 1).'"><a href><i class="fa-solid fa-chevron-left"></i></a></div>';
        }

        if ($page < $countPages) {
            $forward = '<div data-page="' . ($page + 1) . '"><a href><i class="fa-solid fa-chevron-right"></i></a></div>';
        }

        for ($i = $mid_size; $i > 0; $i--) {
            if ($page - $i > 0) {
                $page_left .= '<div data-page="' . ($page - $i) . '"><a href>' . ($page - $i) . '</a></div>';
            }
        }

        for ($i = 1; $i <= $mid_size; $i++) {
            if ($page + $i <= $countPages) {
                $page_right .= '<div data-page="' . ($page + $i) . '"><a href>' . ($page + $i) . '</a></div>';
            }
        }

        if ($page > $mid_size + 1) {
            $start_page = '<div data-page="1"><a href=><i class="fa-solid fa-angles-left"></i></a></div>';
        }

        if ($page < ($countPages - $mid_size)) {
            $end_page = '<div data-page="'.$countPages.'"><a href=><i class="fa-solid fa-angles-right"></i></a></div>';
        }


        return $start_page . $back . $page_left . '<div class="page-active" data-page="' . $page . '"><a>' . $page . '</a></div>' . $page_right . $forward . $end_page;

    }

    public function table($page, $countAll, $limit, $link) {

        $back = '';
        $forward = '';
        $page_left = '';
        $page_right = '';
        $start_page = '';
        $end_page = '';

        $countPages = ceil($countAll / $limit);
        $mid_size = 2;

        if ($page > 1) {
            $back = '<div data-page="'.($page - 1).'"><a href="'.$link.($page - 1).'"><i class="fa-solid fa-chevron-left"></i></a></div>';
        }

        if ($page < $countPages) {
            $forward = '<div data-page="' . ($page + 1) . '"><a href="'.$link.($page + 1).'"><i class="fa-solid fa-chevron-right"></i></a></div>';
        }

        for ($i = $mid_size; $i > 0; $i--) {
            if ($page - $i > 0) {
                $page_left .= '<div data-page="' . ($page - $i) . '"><a href="'.$link.($page - $i).'">' . ($page - $i) . '</a></div>';
            }
        }

        for ($i = 1; $i <= $mid_size; $i++) {
            if ($page + $i <= $countPages) {
                $page_right .= '<div data-page="' . ($page + $i) . '"><a href="'.$link.($page + $i).'">' . ($page + $i) . '</a></div>';
            }
        }

        if ($page > $mid_size + 1) {
            $start_page = '<div data-page="1"><a href="'.$link.'1"><i class="fa-solid fa-angles-left"></i></a></div>';
        }

        if ($page < ($countPages - $mid_size)) {
            $end_page = '<div data-page="'.$countPages.'"><a href="'.$link.$countPages.'"><i class="fa-solid fa-angles-right"></i></a></div>';
        }


        return $start_page . $back . $page_left . '<div class="page-active" data-page="' . $page . '"><a href="'.$link.$page.'">' . $page . '</a></div>' . $page_right . $forward . $end_page;

    }

}

/*class Pagination
{

    public $count_pages = 1;
    public $current_page = 1;
    public $uri = '';
    public $mid_size = 3;
    public $all_pages = 10;

    public function __construct(int $page = 1, int $per_page = 1, int $total = 1)
    {
        $this->count_pages = $this->get_count_pages();
        $this->current_page = $this->get_current_page();
        $this->uri = $this->get_params();
    }

    public function get_start(): int
    {
        return ($this->current_page - 1) * $this->per_page;
    }

    public function get_count_pages(): int
    {
        return ceil($this->total / $this->per_page) ?: 1;
    }

    public function get_current_page(): int
    {
        if ($this->page < 1) {
            $this->page = 1;
        }
        if ($this->page > $this->count_pages) {
            $this->page = $this->count_pages;
        }
        return $this->page;
    }

    public function get_params(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0];
        if (isset($url[1]) && $url[1] != '') {
            $uri .= '?';
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) {
                    $uri .= "{$param}&";
                }
            }
        }
        return $uri;
    }

    public function table(): string {
        $back = '';
        $forward = '';
        $pages_left = '';
        $pages_right = '';

        if ($this->current_page > 1) {
            $back = "<a class='page-item' href='". $this->get_link($this->current_page - 1) ."'>&lt</a>";
        }

        if ($this->current_page < $this->count_pages) {
            $forward = "<a class='page-item' href='". $this->get_link($this->current_page + 1) ."'>&gt</a>";
        }

        for ($i = $this->mid_size; $i > 0; $i--) {
            if ($this->count_pages - $i > 0) {
                $pages_left = "<a class='page-item' href='". $this->get_link($this->current_page - $i) ."'>".$this->current_page - $i."</a>";
            }
        }

        for ($i = 1; $i <= $this->mid_size; $i++) {
            if ($this->count_pages + $i < $this->count_pages) {
                $pages_right = "<a class='page-item' href='". $this->get_link($this->current_page + $i) ."'>".$this->current_page + $i."</a>";
            }
        }

        return '<div class="paginator">' . $back . $pages_left . '<a class="page-item page-active"></a>' . $pages_right . $forward . '</div>';
    }

    public function get_html(): string
    {
        $back = '';
        $forward = '';
        $start_page = '';
        $end_page = '';
        $pages_left = '';
        $pages_right = '';

        if ($this->current_page > 1) {
            $back = "<a class='page-item' href='". $this->get_link($this->current_page - 1) ."'>&lt</a>";
        }

        if ($this->current_page < $this->count_pages) {
            $forward = "<a class='page-item' href='". $this->get_link($this->current_page + 1) ."'>&gt</a>";
        }

        if ($this->current_page > $this->mid_size + 1) {
            $start_page = "<a class='page-item' href='". $this->get_link(1) ."'>&laquo;</a>";
        }

        if ($this->current_page < ($this->count_pages - $this->mid_size)) {
            $end_page = "<a class='page-item' href='". $this->get_link($this->count_pages) ."'>&raquo;</a>";
        }

        for ($i = $this->mid_size; $i > 0; $i--) {
            if ($this->count_pages - $i > 0) {
                $pages_left = "<a class='page-item' href='". $this->get_link($this->current_page - $i) ."'>".$this->current_page - $i."</a>";
            }
        }

        for ($i = 1; $i <= $this->mid_size; $i++) {
            if ($this->count_pages + $i < $this->count_pages) {
                $pages_right = "<a class='page-item' href='". $this->get_link($this->current_page + $i) ."'>".$this->current_page + $i."</a>";
            }
        }

        return '<div class="paginator">'. $start_page . $back . $pages_left . '<a class="page-item page-active"></a>' . $pages_right . $forward . $end_page . '</div>';
    }

    public function get_link($page): string
    {
        if ($page == 1) {
            return rtrim($this->uri, '?&');
        }

        if (str_contains($this->uri, '&')) {
            return "{$this->uri}page={$page}";
        } else {
            if (str_contains($this->uri, '?')) {
                return "{$this->uri}page={$page}";
            } else {
                return "{$this->uri}?page={$page}";
            }
        }
    }
}
*/

















