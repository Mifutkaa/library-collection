<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Приход книг</title>
    <link rel="stylesheet" href="book_arrival.css">
</head>

<body>
    <div class="container">
        <aside class="sidebar">

            <a href="index.html" class="nav-section">Главная</a>

            <button class="nav-section">Справочник</button>
            <div id="handbook" class="submenu">
                <a href="#">(В процессе) Вызов и просмотр справочника</a>
                <a href="#">(В процессе) справочник нового элемента</a>
                <a href="#">(В процессе)Редактирование элемента справочника</a>
                <a href="#">(В процессе)Орфографический контроль</a>
                <a href="#">(В процессе)Удаление элемента справочника</a>
                <a href="#">(В процессе)Копирование элемета справочника</a>
                <a href="#">(В процессе)Печать справочника</a>
                <a href="#">(В процессе)Работа с историей значения справочника</a>
                <a href="#">(В процессе)Поиск в справочнике</a>
                <a href="#">(В процессе)Контекстный поиск</a>
                <a href="#">(В процессе)Скользящий поиск</a>
                <a href="#">(В процессе)Иерархический список справочников</a>
            </div>

            <button class="nav-section">Документы</button>
            <div id="documents" class="submenu">
                <a href="book_arrival.php">Приход книг</a>
                <a href="reader_description.php">Читатели</a>
                <a href="lib_record.php">Ведомость учёта библиотечного фонда</a>
                <a href="inventory_book.php">Инвентарная книга</a>
            </div>

            <button class="nav-section">Отчёты</button>
            <div id="reports" class="submenu">
                <a href="fund_receipt.php">Книга суммарного учёта (Поступление в фонд)</a>
                <a href="book_retirement.php">Книга суммарного учёта (Выбытие книг)</a>
                <a href="fund_movements.php">Книга суммарного учёта (Итоги движения фонда)</a>
            </div>

            <button class="nav-section">Каталоги</button>
            <div id="catalogs" class="submenu">
                <a href="library_catalog.php">Библиотечный каталог</a>
                <a href="magazine_catalog.php">Каталог журналов и газет</a>
            </div>
        </aside>
        <main>
            <div class="header">
                <h1 id="header-title">Библиотечный каталог</h1>
                <p id="header-subtitle">N книг</p>
            </div>

            <div class="controls">
                <div class="dropdown">
                    <button class="dropdown-button">
                        <img src="./img/ico-sorting.svg" alt="Иконка сортировки" class="button-icon">Сортировка
                    </button>
                    <div class="sort-dropdown">
                        <div class="sort-option">
                            <select id="sortColumn" class="sort-select">
                                <option value="">Выберите поле для сортировкия</option>
                                <option value="inventory_number">Инвентарный номер</option>
                                <option value="inventory_date">Дата зап. в инв.кн.</option>
                                <option value="publication_type">Вид издания</option>
                                <option value="authors">Автор(ы) издания</option>
                                <option value="second_author">Второй автор</option>
                                <option value="third_author">Третий автор</option>
                                <option value="responsibility_info">Сведения об ответст-ти</option>
                                <option value="title">Название издания</option>
                                <option value="title_related_info">Свед.относящ.к заглав.</option>
                                <option value="publication_info">Сведения об издании</option>
                                <option value="series">Серия</option>
                                <option value="material_type">Обозначение материала</option>
                                <option value="publication_place">Место издания</option>
                                <option value="publisher">Издательство</option>
                                <option value="year_of_publication">Год издания</option>
                                <option value="page_count">Объем страниц</option>
                                <option value="printed_sheets">Объем печат.листов</option>
                                <option value="mark">Гриф</option>
                                <option value="isbn">ISBN</option>
                                <option value="country">Страна производителя</option>
                                <option value="copies">Количество экземпляров</option>
                                <option value="price">Цена (тенге)</option>
                                <option value="edition_copies">Тираж издания</option>
                                <option value="category">Рубрика</option>
                                <option value="keywords">Ключевое слово</option>
                                <option value="bbk_index">Индекс ББК</option>
                                <option value="udc_index">Индекс УДК</option>
                                <option value="grnti_index">Индекс ГРНТИ</option>
                                <option value="author_sign">Авторский знак</option>
                                <option value="language">Язык текста</option>
                                <option value="summary">Краткое содержание</option>
                                <option value="notes">Примечание</option>
                                <option value="illustrations">Иллюстрация</option>
                                <option value="binding">Переплет</option>
                                <option value="verification_mark_1">Отметка о проверке №1, год</option>
                                <option value="verification_mark_2">Отметка о проверке №2, год</option>
                                <option value="verification_mark_3">Отметка о проверке №3, год</option>
                                <option value="sigla">Сигла</option>
                                <option value="organization_name">Название организации</option>
                                <option value="html_link">HTML ссылка</option>
                                <option value="physical_characteristics">Физические характеристики</option>
                                <option value="system_requirements">Системные требования</option>
                            </select>
                            <select id="sortDirection" class="sort-select">
                                <option value="ASC">По возрастанию</option>
                                <option value="DESC">По убыванию</option>
                            </select>
                            <button id="applySort" class="apply-sort-btn">Применить</button>
                        </div>
                    </div>
                </div>
                <input type="text" placeholder="Поиск">
                <div class="dropdown">
                    <div class="dropdown-content">
                        <div class="button-container">
                            <button class="select-all-button">Выделить всё</button>
                            <button class="reset-button">Сбросить</button>
                        </div>
                        <label class="custom-checkbox">
                            <input type="checkbox" name="column" checked>
                            <span class="checkbox-custom"></span>
                            Клонка
                        </label>
                    </div>
                    <button class="button-action add-book-btn"><img src="./img/ico-reader.svg"
                            alt="Иконка добавления читателя" class="button-icon">Добавить новую запись</button>
                    <button class="button-action export-button"><img src="./img/ico-export.svg" alt="Икнка экспота"
                            class="button-icon">Экспортировать</button>
                </div>
            </div>

            <div id="addBookModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Добавить книгу</h2>
                    <form id="addBookForm">
                        <div class="form-grid">
                            <div>
                                <label for="inventory_number">Инвентарный номер:</label>
                                <input type="text" id="inventory_number" name="inventory_number" required>
                            </div>
                            <div>
                                <label for="inventory_date">Дата зап. в инв.кн.:</label>
                                <input type="date" id="inventory_date" name="inventory_date" required>
                            </div>
                            <div>
                                <label for="publication_type">Вид издания:</label>
                                <input type="text" id="publication_type" name="publication_type">
                            </div>
                            <div>
                                <label for="authors">Автор(ы) издания:</label>
                                <input type="text" id="authors" name="authors">
                            </div>
                            <div>
                                <label for="second_author">Второй автор:</label>
                                <input type="text" id="second_author" name="second_author">
                            </div>
                            <div>
                                <label for="third_author">Третий автор:</label>
                                <input type="text" id="third_author" name="third_author">
                            </div>
                            <div>
                                <label for="responsibility_info">Сведения об ответст-ти:</label>
                                <input type="text" id="responsibility_info" name="responsibility_info">
                            </div>
                            <div>
                                <label for="title">Название издания:</label>
                                <input type="text" id="title" name="title">
                            </div>
                            <div>
                                <label for="title_related_info">Свед.относящ.к заглав.:</label>
                                <input type="text" id="title_related_info" name="title_related_info">
                            </div>
                            <div>
                                <label for="publication_info">Сведения об издании:</label>
                                <input type="text" id="publication_info" name="publication_info">
                            </div>
                            <div>
                                <label for="series">Серия:</label>
                                <input type="text" id="series" name="series">
                            </div>
                            <div>
                                <label for="material_type">Обозначение материала:</label>
                                <input type="text" id="material_type" name="material_type">
                            </div>
                            <div>
                                <label for="publication_place">Место издания:</label>
                                <input type="text" id="publication_place" name="publication_place">
                            </div>
                            <div>
                                <label for="publisher">Издательство:</label>
                                <input type="text" id="publisher" name="publisher">
                            </div>
                            <div>
                                <label for="year_of_publication">Год издания:</label>
                                <input type="text" id="year_of_publication" name="year_of_publication">
                            </div>
                            <div>
                                <label for="page_count">Объе страниц:</label>
                                <input type="text" id="page_count" name="page_count">
                            </div>
                            <div>
                                <label for="printed_sheets">Объем печат.листов:</label>
                                <input type="text" id="printed_sheets" name="printed_sheets">
                            </div>
                            <div>
                                <label for="mark">Гриф:</label>
                                <input type="text" id="mark" name="mark">
                            </div>
                            <div>
                                <label for="isbn">ISBN:</label>
                                <input type="text" id="isbn" name="isbn">
                            </div>
                            <div>
                                <label for="country">Страна производителя:</label>
                                <input type="text" id="country" name="country">
                            </div>
                            <div>
                                <label for="copies">Количество экземпляров:</label>
                                <input type="text" id="copies" name="copies">
                            </div>
                            <div>
                                <label for="price">Цена (тнге):</label>
                                <input type="text" id="price" name="price">
                            </div>
                            <div>
                                <label for="edition_copies">Тираж издания:</label>
                                <input type="text" id="edition_copies" name="edition_copies">
                            </div>
                            <div>
                                <label for="category">Рубрика:</label>
                                <input type="text" id="category" name="category">
                            </div>
                            <div>
                                <label for="keywords">Ключевое слово:</label>
                                <input type="text" id="keywords" name="keywords">
                            </div>
                            <div>
                                <label for="bbk_index">Индекс ББК:</label>
                                <input type="text" id="bbk_index" name="bbk_index">
                            </div>
                            <div>
                                <label for="udc_index">Индекс УДК:</label>
                                <input type="text" id="udc_index" name="udc_index">
                            </div>
                            <div>
                                <label for="grnti_index">Индекс ГРНТИ:</label>
                                <input type="text" id="grnti_index" name="grnti_index">
                            </div>
                            <div>
                                <label for="author_sign">Авторский знак:</label>
                                <input type="text" id="author_sign" name="author_sign">
                            </div>
                            <div>
                                <label for="language">Язык текста:</label>
                                <input type="text" id="language" name="language">
                            </div>
                            <div>
                                <label for="summary">Краткое содержание:</label>
                                <input type="text" id="summary" name="summary">
                            </div>
                            <div>
                                <label for="notes">Примечание:</label>
                                <input type="text" id="notes" name="notes">
                            </div>
                            <div>
                                <label for="illustrations">Иллюстрация:</label>
                                <input type="text" id="illustrations" name="illustrations">
                            </div>
                            <div>
                                <label for="binding">Переплет:</label>
                                <input type="text" id="binding" name="binding">
                            </div>
                            <div>
                                <label for="verification_mark_1">Отметка о проверке №1, год:</label>
                                <input type="text" id="verification_mark_1" name="verification_mark_1">
                            </div>
                            <div>
                                <label for="verification_mark_2">Отметка о проверке №2, год:</label>
                                <input type="text" id="verification_mark_2" name="verification_mark_2">
                            </div>
                            <div>
                                <label for="verification_mark_3">Отметка о проверке №3, год:</label>
                                <input type="text" id="verification_mark_3" name="verification_mark_3">
                            </div>
                            <div>
                                <label for="sigla">Сигла:</label>
                                <input type="text" id="sigla" name="sigla">
                            </div>
                            <div>
                                <label for="organization_name">Название организации:</label>
                                <input type="text" id="organization_name" name="organization_name">
                            </div>
                            <div>
                                <label for="html_link">HTML ссылка:</label>
                                <input type="text" id="html_link" name="html_link">
                            </div>
                            <div>
                                <label for="physical_characteristics">Физические характеристики:</label>
                                <input type="text" id="physical_characteristics" name="physical_characteristics">
                            </div>
                            <div>
                                <label for="system_requirements">Системные требования:</label>
                                <input type="text" id="system_requirements" name="system_requirements">
                            </div>
                        </div>
                        <button type="submit" class="submit-btn">Добавить</button>
                    </form>
                </div>
            </div>


            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="fixed-checkbox">
                                <input type="checkbox" id="selectAll" class="select-all-checkbox">
                            </th>
                            <th>Инвентарный номер</th>
                            <th>Дата зап. в инв.кн.</th>
                            <th>Вид издания</th>
                            <th>Автор(ы) издания</th>
                            <th>Второй автор</th>
                            <th>Третий автор</th>
                            <th>Сведения об ответст-ти</th>
                            <th>Название издания</th>
                            <th>Свед.относящ.к заглав.</th>
                            <th>Сведения об издании</th>
                            <th>Серия</th>
                            <th>Обозначение материала</th>
                            <th>Место издания</th>
                            <th>Издательство</th>
                            <th>Год издания</th>
                            <th>Объем страниц</th>
                            <th>Объем печат.листов</th>
                            <th>Гриф</th>
                            <th>ISBN</th>
                            <th>Страна производителя</th>
                            <th>Количество экземпляров</th>
                            <th>Цена (тенге)</th>
                            <th>Тираж издания</th>
                            <th>Рубрика</th>
                            <th>Ключевое слово</th>
                            <th>Индекс ББК</th>
                            <th>Индекс УДК</th>
                            <th>Индекс ГРНТИ</th>
                            <th>Авторский знак</th>
                            <th>Язык текста</th>
                            <th>Краткое содержание</th>
                            <th>Примечание</th>
                            <th>Иллюстрация</th>
                            <th>Переплет</th>
                            <th>Отметка о проверке №1, год</th>
                            <th>Отметка о проверке №2, год</th>
                            <th>Отметка о проверке №3, год</th>
                            <th>Сигла</th>
                            <th>Название организации</th>
                            <th>HTML ссылка</th>
                            <th>Физические характеристики</th>
                            <th>Системные требования</th>
                            <th class="fixed-menu">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fixed-checkbox"><input type="checkbox" class="row-checkbox"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="fixed-menu">
                                <button class="menu-btn">
                                    <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon"
                                        title="Меню">
                                </button>
                                <div class="menu-options">
                                    <button class="menu-icon-btn edit-btn">
                                        <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать"
                                            class="menu-icon" title="Редактировать">
                                    </button>
                                    <button class="menu-icon-btn delete-btn">
                                        <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить"
                                            class="menu-icon" title="Удалить">
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="assets/js/database-handler.js"></script>
    <script src="assets/js/ui-handler.js"></script>
    <script>
        // Инициализация обработчика базы данных
        const dbHandler = new DatabaseHandler('book_arrival', 'inventory_number');
        console.log('API Path:', dbHandler.apiPath); // Для проверки пути
        const uiHandler = new UIHandler(dbHandler);

        //....... Функция для обновления количества записей .......\\

        function updateBookCount() {
            // Получаем все строки из tbody таблицы
            const rows = document.querySelector('table tbody').getElementsByTagName('tr');
            // Обновляем текст в header-subtitle
            document.getElementById('header-subtitle').textContent = `${rows.length} книг`;
        }

        // Вызываем функцию при загрузке страницы
        document.addEventListener('DOMContentLoaded', updateBookCount);

        // Также можно вызывать эту функцию после добавления или удаления записей
        // Например, после удаления:
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // ... код удаления ...
                updateBookCount(); // обновляем счетчик
            });
        });

        //....... Конец функции для обновления количества записей .......\\

        //....... Обработка открытия/закрытия окна сортировки .......\\
        document.addEventListener('DOMContentLoaded', function () {
            const sortButton = document.querySelector('.dropdown-button');
            const sortDropdown = document.querySelector('.sort-dropdown');

            // Открытие/закрытие при клике на кнопку
            sortButton.addEventListener('click', function (e) {
                e.stopPropagation();
                sortDropdown.style.display = sortDropdown.style.display === 'block' ? 'none' : 'block';
            });

            // Закрытие при клике вне окна
            document.addEventListener('click', function (e) {
                if (!sortDropdown.contains(e.target) && !sortButton.contains(e.target)) {
                    sortDropdown.style.display = 'none';
                }
            });
        });
        //....... Конец функции для обработки открытия/закрытия окна сортировки .......\\

        //....... Обработка открытия/закрытия меню .......\\
        document.addEventListener('DOMContentLoaded', function () {
            // Обработка клика по кнопке меню
            document.querySelectorAll('.menu-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const menuOptions = this.nextElementSibling;
                    // Закрываем все открытые меню
                    document.querySelectorAll('.menu-options').forEach(menu => {
                        if (menu !== menuOptions) {
                            menu.style.display = 'none';
                        }
                    });
                    // Переключаем текущее меню
                    menuOptions.style.display = menuOptions.style.display === 'block' ? 'none' : 'block';
                });
            });

            // Закрытие при клике вне меню
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.fixed-menu')) {
                    document.querySelectorAll('.menu-options').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });
        });
        //....... Конец функции для обработки открытия/закрытия меню .......\\

        //....... Обработка чекбокса "Выбрать все" .......\\
        document.addEventListener('DOMContentLoaded', function () {
            // Получаем главный чекбокс
            const selectAllCheckbox = document.getElementById('selectAll');

            // Обработчик изменения главного чекбокса
            selectAllCheckbox.addEventListener('change', function () {
                // Получаем все чекбоксы в строках таблицы
                const rowCheckboxes = document.querySelectorAll('table tbody .row-checkbox');

                // Устанавливаем всем чекбоксам то же состояние, что и у главного
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });
        //....... Конец функции для обработки чекбокса "Выбрать все" .......\\

        // Функция загрузки данных
        async function loadTableData(sortColumn = '', sortDirection = 'ASC') {
            try {
                const response = await dbHandler.fetchData(sortColumn, sortDirection);
                console.log('Получены данные:', response); // Для отладки
                
                if (response.success && Array.isArray(response.data)) {
                    updateTableData(response.data);
                } else {
                    console.error('Неверный формат данных:', response);
                }
            } catch (error) {
                console.error('Ошибка загрузки данных:', error);
            }
        }

        // Функция обновления данных в существующей таблице
        function updateTableData(data) {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';
            
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="fixed-checkbox">
                        <input type="checkbox" class="row-checkbox">
                    </td>
                    <td>${row.inventory_number || ''}</td>
                    <td>${row.inventory_date || ''}</td>
                    <td>${row.publication_type || ''}</td>
                    <td>${row.authors || ''}</td>
                    <td>${row.second_author || ''}</td>
                    <td>${row.third_author || ''}</td>
                    <td>${row.responsibility_info || ''}</td>
                    <td>${row.title || ''}</td>
                    <td>${row.title_related_info || ''}</td>
                    <td>${row.publication_info || ''}</td>
                    <td>${row.series || ''}</td>
                    <td>${row.material_type || ''}</td>
                    <td>${row.publication_place || ''}</td>
                    <td>${row.publisher || ''}</td>
                    <td>${row.year_of_publication || ''}</td>
                    <td>${row.page_count || ''}</td>
                    <td>${row.printed_sheets || ''}</td>
                    <td>${row.mark || ''}</td>
                    <td>${row.isbn || ''}</td>
                    <td>${row.country || ''}</td>
                    <td>${row.copies || ''}</td>
                    <td>${row.price || ''}</td>
                    <td>${row.edition_copies || ''}</td>
                    <td>${row.category || ''}</td>
                    <td>${row.keywords || ''}</td>
                    <td>${row.bbk_index || ''}</td>
                    <td>${row.udc_index || ''}</td>
                    <td>${row.grnti_index || ''}</td>
                    <td>${row.author_sign || ''}</td>
                    <td>${row.language || ''}</td>
                    <td>${row.summary || ''}</td>
                    <td>${row.notes || ''}</td>
                    <td>${row.illustrations || ''}</td>
                    <td>${row.binding || ''}</td>
                    <td>${row.verification_mark_1 || ''}</td>
                    <td>${row.verification_mark_2 || ''}</td>
                    <td>${row.verification_mark_3 || ''}</td>
                    <td>${row.sigla || ''}</td>
                    <td>${row.organization_name || ''}</td>
                    <td>${row.html_link || ''}</td>
                    <td>${row.physical_characteristics || ''}</td>
                    <td>${row.system_requirements || ''}</td>
                    <td class="fixed-menu">
                        <button class="menu-btn">
                            <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon">
                        </button>
                        <div class="menu-options">
                            <button class="menu-icon-btn edit-btn" data-id="${row.inventory_number}">
                                <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon">
                            </button>
                            <button class="menu-icon-btn delete-btn" data-id="${row.inventory_number}">
                                <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить" class="menu-icon">
                            </button>
                        </div>
                    </td>`;
                tbody.appendChild(tr);
            });

            // Обновляем счетчик книг
            updateBookCount();
            
            // Для отладки
            console.log('Обновлена таблица. Количество записей:', data.length);
            console.log('Данные:', data);
        }

        // Обработчики событий
        document.addEventListener('DOMContentLoaded', function () {
            // Загружаем данные при загрузке страницы
            loadTableData();

            // Обработка добавления новой книги
            const addBookForm = document.getElementById('addBookForm');
            if (addBookForm) {
                addBookForm.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData.entries());

                    try {
                        const result = await dbHandler.addRecord(data);
                        if (result.success) {
                            loadTableData(); // Перезагружаем таблицу
                            document.getElementById('addBookModal').style.display = 'none';
                            this.reset();
                        }
                    } catch (error) {
                        console.error('Ошибка добавления записи:', error);
                    }
                });
            }

            // Обработка удаления
            document.addEventListener('click', async function (e) {
                const deleteBtn = e.target.closest('.delete-btn');
                if (deleteBtn) {
                    const id = deleteBtn.dataset.id;
                    if (confirm('Вы уверены, что хотите удалить эту запись?')) {
                        try {
                            const result = await dbHandler.deleteRecord(id);
                            if (result.success) {
                                loadTableData(); // Перезагружаем таблицу
                            }
                        } catch (error) {
                            console.error('Ошибка удаления записи:', error);
                        }
                    }
                }
            });

            // Обработка сортировки
            const sortButton = document.getElementById('applySort');
            if (sortButton) {
                sortButton.addEventListener('click', function () {
                    const column = document.getElementById('sortColumn').value;
                    const direction = document.getElementById('sortDirection').value;
                    loadTableData(column, direction);
                });
            }

            // Обработка экспорта
            const exportButton = document.querySelector('.export-button');
            if (exportButton) {
                exportButton.addEventListener('click', function () {
                    // Здесь можно добавить логику экспорта
                    alert('Функция экспорта в разработке');
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dbHandler = new DatabaseHandler();
            
            // Обработчик открытия модального окна
            document.querySelector('.add-book-btn').addEventListener('click', function() {
                document.getElementById('addBookModal').style.display = 'block';
            });

            // Обработчик закрытия модального окна
            document.querySelector('.close').addEventListener('click', function() {
                document.getElementById('addBookModal').style.display = 'none';
            });

            // Обработчик отправки формы
            document.getElementById('addBookForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                try {
                    // Собираем данные формы
                    const formData = new FormData(this);
                    const data = {};
                    
                    // Преобразуем FormData в объект
                    formData.forEach((value, key) => {
                        if (value.trim() !== '') {  // Игнорируем пустые значения
                            data[key] = value;
                        }
                    });

                    // Проверяем обязательные поля
                    if (!data.inventory_number) {
                        alert('Пожалуйста, заполните инвентарный номер');
                        return;
                    }

                    // Оправляем данные
                    const result = await dbHandler.addNewRecord(data);

                    // Если успешно
                    alert('Запись успешно добавлена!');
                    
                    // Закрываем модальное окно
                    document.getElementById('addBookModal').style.display = 'none';
                    
                    // Очищаем форму
                    this.reset();
                    
                    // Обновляем таблицу
                    await loadTableData();

                } catch (error) {
                    alert(`Ошибка: ${error.message}`);
                }
            });
        });

        // Обработка меню для каждой записи
        document.addEventListener('click', function(e) {
            // Если клик был по кнопке меню
            if (e.target.closest('.menu-btn')) {
                e.stopPropagation(); // Предотвращаем всплытие события
                
                // Закрываем все открытые меню
                document.querySelectorAll('.menu-options').forEach(menu => {
                    if (menu !== e.target.closest('.menu-btn').nextElementSibling) {
                        menu.style.display = 'none';
                    }
                });
                
                // Переключаем текущее меню
                const menuOptions = e.target.closest('.menu-btn').nextElementSibling;
                menuOptions.style.display = menuOptions.style.display === 'block' ? 'none' : 'block';
            }
            // Если клик был вне меню, закрываем все меню
            else if (!e.target.closest('.menu-options')) {
                document.querySelectorAll('.menu-options').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });

        // Обработка кнопок в меню
        document.addEventListener('click', function(e) {
            // Обработка кнопки редактирования
            if (e.target.closest('.edit-btn')) {
                const id = e.target.closest('.edit-btn').dataset.id;
                // Здесь код для редактирования
                console.log('Редактирование записи:', id);
            }
            
            // Обработка кнопки удаления
            if (e.target.closest('.delete-btn')) {
                const id = e.target.closest('.delete-btn').dataset.id;
                if (confirm('Вы уверены, что хотите удалить эту запись?')) {
                    console.log('Удаление записи:', id);
                    // Здесь код для удаления
                }
            }
        });


        function createTableHeader() {
            const thead = document.querySelector('table thead');
            thead.innerHTML = `
                <tr>
                    <th class="fixed-checkbox">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th data-column="inventory_number">Инв. номер</th>
                    <th data-column="inventory_date">Дата</th>
                    <th data-column="publication_type">Тип</th>
                    <th data-column="authors">Авторы</th>
                    <th data-column="second_author">Второй автор</th>
                    <th data-column="third_author">Третий автор</th>
                    <th data-column="responsibility_info">Ответственность</th>
                    <th data-column="title">Название</th>
                    <th data-column="title_related_info">Доп. информация</th>
                    <th data-column="publication_info">Публикация</th>
                    <th data-column="series">Серия</th>
                    <th data-column="material_type">Тип материала</th>
                    <th data-column="publication_place">Место издания</th>
                    <th data-column="publisher">Издательство</th>
                    <th data-column="year_of_publication">Год</th>
                    <th data-column="page_count">Страниц</th>
                    <th data-column="printed_sheets">Печатные листы</th>
                    <th data-column="mark">Метка</th>
                    <th data-column="isbn">ISBN</th>
                    <th data-column="country">Страна</th>
                    <th data-column="copies">Копии</th>
                    <th data-column="price">Цена</th>
                    <th data-column="edition_copies">Тираж</th>
                    <th data-column="category">Категория</th>
                    <th data-column="keywords">Ключевые слова</th>
                    <th data-column="bbk_index">BBK</th>
                    <th data-column="udc_index">UDC</th>
                    <th data-column="grnti_index">GRNTI</th>
                    <th data-column="author_sign">Авторский знак</th>
                    <th data-column="language">Язык</th>
                    <th data-column="summary">Аннотация</th>
                    <th data-column="notes">Заметки</th>
                    <th data-column="illustrations">Иллюстрации</th>
                    <th data-column="binding">Переплет</th>
                    <th data-column="verification_mark_1">Проверка 1</th>
                    <th data-column="verification_mark_2">Проверка 2</th>
                    <th data-column="verification_mark_3">Проверка 3</th>
                    <th data-column="sigla">Сигла</th>
                    <th data-column="organization_name">Организация</th>
                    <th data-column="html_link">Ссылка</th>
                    <th data-column="physical_characteristics">Физ. характеристики</th>
                    <th data-column="system_requirements">Системные требования</th>
                    <th class="fixed-menu">Действия</th>
                </tr>
            `;
        }

        // Функция для работы навигации
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем все кнопки навигации
            const navButtons = document.querySelectorAll('.nav-section');
            
            // Добавляем обработчик для каждой кнопки
            navButtons.forEach(button => {
                if (button.tagName !== 'A') { // Пропускаем ссылки
                    button.addEventListener('click', function() {
                        // Находим следующий элемент (подменю)
                        const submenu = this.nextElementSibling;
                        
                        // Закрываем все остальные подменю
                        document.querySelectorAll('.submenu').forEach(menu => {
                            if (menu !== submenu) {
                                menu.style.display = 'none';
                            }
                        });
                        
                        // Переключаем видимость текущего подменю
                        if (submenu && submenu.classList.contains('submenu')) {
                            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                        }
                    });
                }
            });
            
            // Закрытие подменю при клике вне его
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.nav-section') && !event.target.closest('.submenu')) {
                    document.querySelectorAll('.submenu').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });
            
            // Добавляем активный класс для текущей страницы
            const currentPage = window.location.pathname.split('/').pop();
            document.querySelectorAll('.submenu a').forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.style.backgroundColor = '#e0e0e0';
                    link.parentElement.style.display = 'block';
                }
            });
        });
    </script>
</body>

</html>