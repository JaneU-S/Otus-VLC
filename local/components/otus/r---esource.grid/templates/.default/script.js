BX.namespace('Otus.BookGrid');

BX.Otus.BookGrid = {
    signedParams: null,
    init: function(data) {
        this.signedParams = data.signedParams;
    },
    showMessage: function (message) {
        alert(message);
    },
    addTestBookElement: function () {
        BX.ajax.runComponentAction('otus:book.grid', 'addTestBookElement', {
            mode: 'class',
            signedParameters: BX.Otus.BookGrid.signedParams,
            data: {
                bookData: {
                    bookTitle: "Тестовая книга",
                    authors: [
                        1, // идентификатор автора в таблица aholin_author
                        2,
                    ],
                    publishYear: 2025,
                    pageCount: 55,
                    publishDate: '24.07.2025',
                },
            },
        }).then(response => {
            BX.Otus.BookGrid.showMessage('Создана книга с ID=' + response.data.BOOK_ID);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
    createAlternativeTestBookElement: function () {
        BX.ajax.runComponentAction('otus:book.grid', 'createTestElement', {
            mode: 'ajax',
            signedParameters: BX.Otus.BookGrid.signedParams,
            data: null,
        }).then(response => {
            BX.Otus.BookGrid.showMessage('Создана книга с ID=' + response.data.BOOK_ID);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
    createTestElementViaModule: function () {
        BX.ajax.runAction(
            'aholin:crmcustomtab.BookActions.BookController.createTestElement',
            {}
        ).then(response => {
            BX.Otus.BookGrid.showMessage('Создана книга с ID=' + response.data.BOOK_ID);
            let grid = BX.Main.gridManager.getById('BOOK_GRID')?.instance;
            grid.reload();
        }, reject => {
            let errorMessage = '';
            for (let error of reject.errors) {
                errorMessage += error.message + '\n';
            }

            BX.Otus.BookGrid.showMessage(errorMessage);
        });
    },
}