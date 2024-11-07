<?php
try {
    $dbPath = __DIR__ . '/database/inventory.db';
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из таблицы
    $stmt = $db->query("SELECT * FROM inventory ORDER BY entry_date DESC");
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $records = [];
}
?>

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
            </div>

        </aside>
        <main>
            <div class="header">
                <h1 id="header-title">Инвентарная книга</h1>
                <p id="header-subtitle">N книг</p>
            </div>

            <div class="controls">
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
                                <label for="title">Название книги:</label>
                                <input type="text" id="title" name="title" required>
                            </div>
                            <div>
                                <label for="authors">Автор(ы):</label>
                                <input type="text" id="authors" name="authors" required>
                            </div>
                            <div>
                                <label for="publication_year">Год издания:</label>
                                <input type="number" id="publication_year" name="publication_year" required>
                            </div>
                            <div>
                                <label for="publisher">Издательство:</label>
                                <input type="text" id="publisher" name="publisher" required>
                            </div>
                            <div>
                                <label for="ISBN">ISBN:</label>
                                <input type="text" id="ISBN" name="ISBN" required>
                            </div>
                            <div>
                                <label for="inventory_number">Инвентарный номер:</label>
                                <input type="text" id="inventory_number" name="inventory_number" required>
                            </div>
                            <div>
                                <label for="category">Категория:</label>
                                <select id="category" name="category" required>
                                    <option value="Учебная литература">Учебная литература</option>
                                    <option value="Художественная литература">Художественная литература</option>
                                    <option value="Научная литература">Научная литература</option>
                                    <option value="Справочная литература">Справочная литература</option>
                                </select>
                            </div>
                            <div>
                                <label for="location">Местоположение:</label>
                                <input type="text" id="location" name="location" required>
                            </div>
                            <div>
                                <label for="entry_date">Дата поступления:</label>
                                <input type="date" id="entry_date" name="entry_date" required>
                            </div>
                            <div>
                                <label for="condition">Состояние:</label>
                                <select id="condition" name="condition" required>
                                    <option value="Новая">Новая</option>
                                    <option value="Хорошее">Хорошее</option>
                                    <option value="Удовлетворительное">Удовлетворительное</option>
                                    <option value="Требует ремонта">Требует ремонта</option>
                                </select>
                            </div>
                            <div>
                                <label for="availability">Доступность:</label>
                                <select id="availability" name="availability" required>
                                    <option value="1">Доступна</option>
                                    <option value="0">Недоступна</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="submit-btn">Сохранить</button>
                    </form>
                </div>
            </div>


            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="fixed-checkbox">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Название книги</th>
                            <th>Автор(ы)</th>
                            <th>Год издания</th>
                            <th>Издательство</th>
                            <th>ISBN</th>
                            <th>Инвентарный номер</th>
                            <th>Категория</th>
                            <th>Местоположение</th>
                            <th>Дата поступления</th>
                            <th>Состояние</th>
                            <th>Доступность</th>
                            <th class="fixed-menu">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Данные будут загружены через JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="assets/js/database-handler.js"></script>
    <script src="assets/js/ui-handler.js"></script>
    <script>
        // Добавляем функцию для безопасного экранирования HTML
        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return unsafe
                .toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Функция загрузки данных таблицы
        async function loadTableData() {
            try {
                const response = await fetch('handlers/get_inventory.php');
                const result = await response.json();

                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';

                if (result.success && Array.isArray(result.data)) {
                    result.data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="fixed-checkbox">
                                <input type="checkbox" class="row-checkbox">
                            </td>
                            <td>${escapeHtml(row.title)}</td>
                            <td>${escapeHtml(row.authors)}</td>
                            <td>${escapeHtml(row.publication_year)}</td>
                            <td>${escapeHtml(row.publisher)}</td>
                            <td>${escapeHtml(row.ISBN)}</td>
                            <td>${escapeHtml(row.inventory_number)}</td>
                            <td>${escapeHtml(row.category)}</td>
                            <td>${escapeHtml(row.location)}</td>
                            <td>${escapeHtml(row.entry_date)}</td>
                            <td>${escapeHtml(row.condition)}</td>
                            <td>${row.availability ? 'Доступна' : 'Недоступна'}</td>
                            <td class="fixed-menu">
                                <button class="menu-btn">
                                    <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon">
                                </button>
                                <div class="menu-options">
                                    <button class="menu-icon-btn edit-btn" data-id="${escapeHtml(row.inventory_number)}">
                                        <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon">
                                    </button>
                                    <button class="menu-icon-btn delete-btn" data-id="${escapeHtml(row.inventory_number)}">
                                        <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить" class="menu-icon">
                                    </button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });

                    updateBookCount();
                } else {
                    throw new Error(result.error || 'Неверный формат данных');
                }
            } catch (error) {
                console.error('Ошибка загрузки данных:', error);
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = `<tr><td colspan="13" style="text-align: center; color: red;">Ошибка загрузки данных: ${error.message}</td></tr>`;
            }
        }

        // Функция обновления счетчика книг
        function updateBookCount() {
            const rows = document.querySelector('table tbody').getElementsByTagName('tr');
            const headerSubtitle = document.getElementById('header-subtitle');
            if (headerSubtitle) {
                headerSubtitle.textContent = `${rows.length} книг`;
            }
        }

        // Инициализация при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            loadTableData();

            // Инициализация поиска
            const searchInput = document.querySelector('.controls input[placeholder="Поиск"]');
            if (!searchInput) {
                console.error('Элемент поиска не найден');
                return;
            }

            // Обработчик поиска
            searchInput.addEventListener('input', function(e) {
                const searchText = e.target.value.toLowerCase();
                const tbody = document.querySelector('table tbody');
                const rows = tbody.getElementsByTagName('tr');

                Array.from(rows).forEach(row => {
                    // Пропускаем строку с сообщением об ошибке
                    if (row.cells.length === 1 && row.cells[0].getAttribute('colspan')) {
                        return;
                    }

                    let found = false;
                    // Начинаем с индекса 1, чтобы пропустить чекбокс, и заканчиваем -1, чтобы пропустить колонку действий
                    for (let i = 1; i < row.cells.length - 1; i++) {
                        const cellText = row.cells[i].textContent.toLowerCase();
                        if (cellText.includes(searchText)) {
                            found = true;
                            break;
                        }
                    }
                    row.style.display = found ? '' : 'none';
                });

                // Обновляем счетчик с учетом поиска
                updateBookCount(true);
            });

            // Обновляем функцию подсчета записей
            function updateBookCount(isSearch = false) {
                const tbody = document.querySelector('table tbody');
                const rows = tbody.getElementsByTagName('tr');
                let visibleCount = 0;

                Array.from(rows).forEach(row => {
                    // Пропускаем строку с сообщением об ошибке
                    if (row.cells.length === 1 && row.cells[0].getAttribute('colspan')) {
                        return;
                    }
                    if (row.style.display !== 'none') {
                        visibleCount++;
                    }
                });

                const headerSubtitle = document.getElementById('header-subtitle');
                if (headerSubtitle) {
                    if (isSearch) {
                        const totalCount = Array.from(rows).filter(row => 
                            !(row.cells.length === 1 && row.cells[0].getAttribute('colspan'))
                        ).length;
                        headerSubtitle.textContent = `Найдено ${visibleCount} из ${totalCount} книг`;
                    } else {
                        headerSubtitle.textContent = `${visibleCount} книг`;
                    }
                }
            }

            // Добавляем очистку поиска при нажатии Escape
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    this.dispatchEvent(new Event('input'));
                }
            });

            // Стилизация поля поиска
            searchInput.style.padding = '8px 30px 8px 8px';
            searchInput.style.border = '1px solid #ddd';
            searchInput.style.borderRadius = '4px';
            searchInput.style.marginBottom = '10px';
            searchInput.style.width = '200px';

            // Обновляем placeholder
            searchInput.placeholder = 'Поиск по всем полям...';

            // Инициализация таблицы при загрузке страницы
            loadTableData();
        });

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
        //....... Конец функции для обработки открытия/закрытия мню .......\\

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
        async function loadTableData() {
            try {
                const response = await fetch('handlers/get_inventory.php');
                const result = await response.json();

                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';

                if (result.success && Array.isArray(result.data)) {
                    result.data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="fixed-checkbox">
                                <input type="checkbox" class="row-checkbox">
                            </td>
                            <td>${escapeHtml(row.title)}</td>
                            <td>${escapeHtml(row.authors)}</td>
                            <td>${escapeHtml(row.publication_year)}</td>
                            <td>${escapeHtml(row.publisher)}</td>
                            <td>${escapeHtml(row.ISBN)}</td>
                            <td>${escapeHtml(row.inventory_number)}</td>
                            <td>${escapeHtml(row.category)}</td>
                            <td>${escapeHtml(row.location)}</td>
                            <td>${escapeHtml(row.entry_date)}</td>
                            <td>${escapeHtml(row.condition)}</td>
                            <td>${row.availability ? 'Доступна' : 'Недоступна'}</td>
                            <td class="fixed-menu">
                                <button class="menu-btn">
                                    <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon">
                                </button>
                                <div class="menu-options">
                                    <button class="menu-icon-btn edit-btn" data-id="${escapeHtml(row.inventory_number)}">
                                        <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon">
                                    </button>
                                    <button class="menu-icon-btn delete-btn" data-id="${escapeHtml(row.inventory_number)}">
                                        <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить" class="menu-icon">
                                    </button>
                                </div>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });

                    updateBookCount();
                } else {
                    throw new Error(result.error || 'Неверный формат данных');
                }
            } catch (error) {
                console.error('Ошибка загрузки данных:', error);
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = `<tr><td colspan="13" style="text-align: center; color: red;">Ошибка загрузки данных: ${error.message}</td></tr>`;
            }
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