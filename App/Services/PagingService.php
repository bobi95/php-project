<?php
/**
 * Created by PhpStorm.
 * User: Borislav
 * Date: 2016-03-18
 * Time: 15:14
 */

namespace App\Services;


use App\DataAccess\BaseRepository;

class PagingService {
    public static function getElements(BaseRepository $repo, $page, $maxItems, $sort = [], $filter = []) {
        $count = $repo->count($filter);

        $pages =  (int)ceil(((double)$count) / $maxItems);

        if ($page > $pages) {
            $page = $pages;
        } else if ($page < 1) {
            $page = 1;
        }

        $elements = $repo->getAll($maxItems, ($page - 1) * $maxItems, $sort, $filter);

        $numbers = [];

        $maxPages = 5;

        if ($pages < $maxPages) {
            $minPage = 1;
            $maxPage = $pages;
        } else if ($page <= $maxPages / 2) {
            $minPage = 1;
            $maxPage = $maxPages;
        } else if ($page > $pages - $maxPages / 2) {
            $minPage = $pages - $maxPages + 1;
            $maxPage = $pages;
        } else {
            $minPage = $page - $maxPages / 2;
            $maxPage = $page + $maxPages / 2;

            if ($maxPage - $minPage + 1 > $maxPages) {
                $minPage += 1;
            }
        }

        for($i = $minPage; $i <= $maxPage; $i++) {
            $numbers[] = $i;
        }

        return [
            'page' => $page,
            'pages' => $pages,
            'numbers' => $numbers,
            'elements' => $elements,
            'count' => $count
        ];
    }
}