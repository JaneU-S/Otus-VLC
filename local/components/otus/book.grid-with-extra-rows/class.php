<?php

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\Filter\Options as FilterOptions;
use Models\Lists\BookTable;
use Models\Lists\AuthorTable;
use Bitrix\Main\ORM\Query\Result;
use Bitrix\UI\Buttons\Color;
use Bitrix\Main\Error;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorableImplementation;

class BookGrid extends \CBitrixComponent implements Controllerable, Errorable
{
    use ErrorableImplementation;

    public function onPrepareComponentParams($arParams): array
    {
        $arParams['BOOK_PREFIX'] = strtolower($arParams['BOOK_PREFIX']);
        return $arParams;
    }

    public function listKeysSignedParameters(): array
    {
        return [
            'BOOK_PREFIX',
        ];
    }

    public function configureActions(): array
    {
        return [];
    }

    private function getElementActions(): array
    {
        return [];
    }

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public function addTestBookElementAction(array $bookData): array
    {
        $newBookData = [
            'TITLE' => $this->arParams['BOOK_PREFIX'] . $bookData['bookTitle'] ?? '',
            'YEAR' => $bookData['publishYear'] ?? 2000,
            'PAGES' => $bookData['pageCount'] ?? 0,
            'PUBLISH_DATE' => DateTime::createFromText($bookData['publishDate'] ?? ''),
        ];

        $addResult = BookTable::add($newBookData);
        if (!$addResult->isSuccess()) {
            $this->errorCollection->add([new Error('Не удалось создать книгу')]);
            return [];
        }

        $bookId = $addResult->getId();
        $book = BookTable::getByPrimary($bookId)->fetchObject();

        $authorIds = $bookData['authors'];
        foreach ($authorIds as $authorId) {
            $author = AuthorTable::getByPrimary($authorId)->fetchObject();
            if ($author) {
                $book->addToAuthors($author);
            }
        }

        $updateResult = $book->save();

        if (!$updateResult->isSuccess()) {
            $this->errorCollection->add([new Error('Не удалось добавить авторов')]);
            return [];
        }

        return [
            'BOOK_ID' => $bookId
        ];
    }

    private function getHeaders(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'sort' => 'ID',
                'default' => true,
            ],
            [
                'id' => 'TITLE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_TITLE_LABEL'),
                'sort' => 'TITLE',
                'default' => true,
            ],
            [
                'id' => 'YEAR',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_YEAR_LABEL'),
                'sort' => 'YEAR',
                'default' => true,
            ],
            [
                'id' => 'PAGES',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PAGES_LABEL'),
                'sort' => 'PAGES',
                'default' => true,
            ],
            [
                'id' => 'AUTHORS',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_AUTHORS_LABEL'),
                'default' => true,
            ],
            [
                'id' => 'PUBLISH_DATE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_DATE_LABEL'),
                'sort' => 'PUBLISH_DATE',
                'default' => true,
            ],
            [
                'id' => 'DEAL',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_DEAL_LABEL'),
                'sort' => 'DEAL',
                'default' => true,
            ],
        ];
    }

    protected function getButtons(): array
    {
        return [
            [
                'link' => '?EXPORT_MODE=Y',
                'text' => Loc::getMessage('EXPORT_XLSX_BUTTON_TITLE'),
                'color' => Color::PRIMARY,
            ],
//            [
//                'onclick' => 'BX.Otus.BookGrid.addTestBookElement',
//                'text' => Loc::getMessage('ADD_TEST_BOOK_BUTTON_TITLE'),
//                'color' => Color::SUCCESS,
//            ],
//            [
//                'onclick' => 'BX.Otus.BookGrid.createAlternativeTestBookElement',
//                'text' => Loc::getMessage('ADD_TEST_BOOK_BUTTON_TITLE') . ' - альтернативное применение',
//                'color' => Color::DANGER_LIGHT,
//            ],
//            [
//                'onclick' => 'BX.Otus.BookGrid.createTestElementViaModule',
//                'text' => Loc::getMessage('ADD_TEST_BOOK_BUTTON_TITLE') . ' - через модуль',
//                'color' => Color::PRIMARY_DARK,
//            ],
            [
                'onclick' => 'showConfirmationBookPopup',
                'text' => 'Подтвердите согласие на чтение книги',
                'color' => Color::DANGER,
            ],
        ];
    }

    public function executeComponent(): void
    {
        if ($this->request->get('EXPORT_MODE') == 'Y') {
            $this->setTemplateName('excel');
        }

        $this->arResult['BUTTONS'] = $this->getButtons();
        $this->prepareGridData();
        $this->includeComponentTemplate();
    }

    private function prepareGridData(): void
    {
        $this->arResult['HEADERS'] = $this->getHeaders();
        $this->arResult['FILTER_ID'] = 'BOOK_GRID';

        $gridOptions = new GridOptions($this->arResult['FILTER_ID']);
        $this->arResult['USED_HEADERS'] = $gridOptions->getUsedColumns($this->arResult['HEADERS']);
        $navParams = $gridOptions->getNavParams();

        $nav = new PageNavigation($this->arResult['FILTER_ID']);
        $nav->allowAllRecords(true)
            ->setPageSize($navParams['nPageSize'])
            ->initFromUri();

        $filterOption = new FilterOptions($this->arResult['FILTER_ID']);
        $filterData = $filterOption->getFilter([]);
        $filter = $this->prepareFilter($filterData);


        $sort = $gridOptions->getSorting([
            'sort' => [
                'ID' => 'DESC',
            ],
            'vars' => [
                'by' => 'by',
                'order' => 'order',
            ],
        ]);

        $bookIdsQuery = BookTable::query()
            ->setSelect(['ID'])
            ->setFilter($filter)
            ->setLimit($nav->getLimit())
            ->setOffset($nav->getOffset())
            ->setOrder($sort['sort'])
        ;

        $countQuery = BookTable::query()
            ->setSelect(['ID'])
            ->setFilter($filter)
        ;
        $nav->setRecordCount($countQuery->queryCountTotal());

        $bookIds = array_column($bookIdsQuery->exec()->fetchAll(), 'ID');

        if (!empty($bookIds)) {
            $books = BookTable::getList([
                'filter' => ['ID' => $bookIds] + $filter,
                'select' => [
                    'ID',
                    'TITLE',
                    'YEAR',
                    'PAGES',
                    'PUBLISH_DATE',
                    'DEAL_ID',
                    'AUTHOR_ID' => 'AUTHORS.ID',
                    'AUTHOR_FIRST_NAME' => 'AUTHORS.FIRST_NAME',
                    'AUTHOR_LAST_NAME' => 'AUTHORS.LAST_NAME',
                    'AUTHOR_SECOND_NAME' => 'AUTHORS.SECOND_NAME',
                ],
                'order' => $sort['sort'],
            ]);

            $this->arResult['GRID_LIST'] = $this->prepareGridList($books);
        } else {
            $this->arResult['GRID_LIST'] = [];
        }

        $this->arResult['NAV'] = $nav;
        $this->arResult['UI_FILTER'] = $this->getFilterFields();
    }

    private function prepareFilter(array $filterData): array
    {
        $filter = [];

        if (!empty($filterData['FIND'])) {
            $filter['%TITLE'] = $filterData['FIND'];
        }

        if (!empty($filterData['TITLE'])) {
            $filter['%TITLE'] = $filterData['TITLE'];
        }

        if (!empty($filterData['YEAR_from'])) {
            $filter['>=YEAR'] = $filterData['YEAR_from'];
        }

        if (!empty($filterData['YEAR_to'])) {
            $filter['<=YEAR'] = $filterData['YEAR_to'];
        }

        if (!empty($filterData['PUBLISH_DATE_from'])) {
            $filter['>=PUBLISH_DATE'] = $filterData['PUBLISH_DATE_from'];
        }

        if (!empty($filterData['PUBLISH_DATE_to'])) {
            $filter['<=PUBLISH_DATE'] = $filterData['PUBLISH_DATE_to'];
        }

        return $filter;
    }

    private function prepareGridList(Result $books): array
    {
        $gridList = [];
        $groupedBooks = [];

        while ($book = $books->fetch()) {
            $bookId = $book['ID'];

            if (!isset($groupedBooks[$bookId])) {
                $groupedBooks[$bookId] = [
                    'ID' => $book['ID'],
                    'TITLE' => $book['TITLE'],
                    'YEAR' => $book['YEAR'],
                    'PAGES' => $book['PAGES'],
                    'PUBLISH_DATE' => $book['PUBLISH_DATE'],
                    'AUTHORS' => [],
                    'DEAL' => sprintf('/crm/deal/details/%d/', $book['DEAL_ID']),
                    'DEAL_ID' => $book['DEAL_ID'],
                ];
            }

            if ($book['AUTHOR_ID']) {
                $groupedBooks[$bookId]['AUTHORS'][] = implode(' ', array_filter([
                    $book['AUTHOR_LAST_NAME'],
                    $book['AUTHOR_FIRST_NAME'],
                    $book['AUTHOR_SECOND_NAME']
                ]));
            }
        }

        $i = 1;
        foreach ($groupedBooks as $book) {
            $gridList[] = [
                'data' => [
                    'ID' => $book['ID'],
                    'TITLE' => $book['TITLE'],
                    'YEAR' => $book['YEAR'],
                    'PAGES' => $book['PAGES'],
                    'AUTHORS' => implode(', ', $book['AUTHORS']),
                    'PUBLISH_DATE' => $book['PUBLISH_DATE']->format('d.m.Y'),
                    'DEAL' => $this->prepareDealLink($book['DEAL'], $book['DEAL_ID']),
                ],
                'id' => $i++,
                'actions' => $this->getElementActions(),
                'attrs' => [
                    'is-section' => true,
                ],
            ];
        }
        $gridList[] = [
            'data' => [
                'ID' => '321',
                'TITLE' => 'Думай и богатей',
                'YEAR' => '1953',
                'PAGES' => 123,
                'AUTHORS' => 'Наполеон Хилл',
                'PUBLISH_DATE' => (new \DateTime)->format('d.m.Y'),
            ],
            'id' => $i,
            'actions' => $this->getElementActions(),
            'attrs' => [
                'is-section' => false,
                'parent' => --$i,
            ],
        ];

        return $gridList;
    }

    private function prepareDealLink(string $url, int $dealId): string
    {
        return sprintf('<div class="slider-open-btn" onclick="openLinkInSlider(\'%s\')"><a>%s</a></div>', $url, $dealId);
    }

    private function getFilterFields(): array
    {
        return [
            [
                'id' => 'TITLE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_TITLE_LABEL'),
                'type' => 'string',
                'default' => true,
            ],
            [
                'id' => 'YEAR',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_YEAR_LABEL'),
                'type' => 'number',
                'default' => true,
            ],
            [
                'id' => 'PUBLISH_DATE',
                'name' => Loc::getMessage('BOOK_GRID_BOOK_PUBLISHING_DATE_LABEL'),
                'type' => 'date',
                'default' => true,
            ],
        ];
    }
}
