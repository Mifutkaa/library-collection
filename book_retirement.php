<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Книга суммарного учёта (Выбытие книг)</title>
    <link rel="stylesheet" href="book_retirement.css">
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
                <a href="fund_receipt.php">Книга суммарного учёта (Поступлние в фонд)</a>
                <a href="book_retirement.php">Книга суммарного учёта (Выбытие книг)</a>
                <a href="fund_movements.php">Книга суммарного учёта (Итоги движения фонда)</a>
            </div>
        </aside>
        <main>
            <div class="header">
                <h1 id="header-title">Книга суммарного учёта (Выбыте книг)</h1>
                <p id="header-subtitle">N книг</p>
            </div>

            <div class="controls">
                <div class="dropdown">
                    <button class="dropdown-button">
                        <img src="./img/ico-sorting.svg"" alt=" Иконка сортировки" class="button-icon">Сортировка
                    </button>
                    <div class="sort-dropdown">
                        <div class="sort-option">
                            <select id="sortColumn" class="sort-select">
                                <option value="">Выберите поле для сортировки</option>
                                <option value="inventory_number">Инвентарный номер</option>
                                <option value="title">Название книги</option>
                                <option value="author">Автор(ы)</option>
                                <option value="publication_year">Год издания</option>
                                <option value="publisher">Издательство</option>
                                <option value="isbn">ISBN</option>
                            </select>
                            <select id="sortDirection" class="sort-select">
                                <option value="ASC">По возрастанию</option>
                                <option value="DESC">По убыванию</option>
                            </select>
                        </div>
                        <div class="button-container">
                            <button class="apply-button">Применить</button>
                            <button class="reset-button">Сбросить</button>
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
                            Колонка
                        </label>
                    </div>
                    <button class="button-action add-book-btn"><img src="./img/ico-reader.svg"
                            alt="Иконка добавления читателя" class="button-icon">Добавить новую запись</button>
                    <button class="button-action export-button"><img src="./img/ico-export.svg" alt="Иконка экспорта"
                            class="button-icon">Экспортировать</button>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="fixed-checkbox">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th data-column="inventory_number">Инв. номер</th>
                            <th data-column="title">Название книги</th>
                            <th data-column="author">Автор(ы)</th>
                            <th data-column="publication_year">Год издания</th>
                            <th data-column="publisher">Издательство</th>
                            <th data-column="isbn">ISBN</th>
                            <th data-column="category">Категория</th>
                            <th data-column="total_copies">Кол-во экземпляров</th>
                            <th data-column="condition">Состояние</th>
                            <th data-column="date_added">Дата добавления</th>
                            <th data-column="note">Примечание</th>
                            <th class="fixed-menu">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <!-- Модальное окно добавления/редактирования -->
            <div id="addBookModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Добавить запись</h2>
                    <form id="addBookForm">
                        <div class="form-grid">
                            <div>
                                <label for="inventory_number">Инвентарный номер:</label>
                                <input type="number" id="inventory_number" name="inventory_number" required>
                            </div>
                            <div>
                                <label for="title">Название книги:</label>
                                <input type="text" id="title" name="title" required>
                            </div>
                            <div>
                                <label for="author">Автор(ы):</label>
                                <input type="text" id="author" name="author">
                            </div>
                            <div>
                                <label for="publication_year">Год издания:</label>
                                <input type="number" id="publication_year" name="publication_year">
                            </div>
                            <div>
                                <label for="publisher">Издательство:</label>
                                <input type="text" id="publisher" name="publisher">
                            </div>
                            <div>
                                <label for="isbn">ISBN:</label>
                                <input type="text" id="isbn" name="isbn">
                            </div>
                            <div>
                                <label for="category">Категория:</label>
                                <input type="text" id="category" name="category">
                            </div>
                            <div>
                                <label for="total_copies">Количество экземпляров:</label>
                                <input type="number" id="total_copies" name="total_copies" required>
                            </div>
                            <div>
                                <label for="condition">Состояние:</label>
                                <select id="condition" name="condition">
                                    <option value="Новая">Новая</option>
                                    <option value="Хорошее">Хорошее</option>
                                    <option value="Удовлетворительное">Удовлетворительное</option>
                                    <option value="Требует ремонта">Требует ремонта</option>
                                </select>
                            </div>
                            <div>
                                <label for="date_added">Дата добавления:</label>
                                <input type="date" id="date_added" name="date_added" required>
                            </div>
                            <div>
                                <label for="note">Примечание:</label>
                                <textarea id="note" name="note"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="submit-btn">Сохранить</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/database-handler.js"></script>
    <script>
        // Инициализация обработчика базы данных
        const dbHandler = new DatabaseHandler('lib_record');

        // Загрузка данных при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            loadTableData();
            setupEventListeners();
            updateBookCount();
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
        document.addEventListener('DOMContentLoaded', function() {
            const sortButton = document.querySelector('.dropdown-button');
            const sortDropdown = document.querySelector('.sort-dropdown');

            // Открытие/закрытие при клике на кнопку
            sortButton.addEventListener('click', function(e) {
                e.stopPropagation();
                sortDropdown.style.display = sortDropdown.style.display === 'block' ? 'none' : 'block';
            });

            // Закрытие при клике вне окна
            document.addEventListener('click', function(e) {
                if (!sortDropdown.contains(e.target) && !sortButton.contains(e.target)) {
                    sortDropdown.style.display = 'none';
                }
            });
        });
        //....... Конец функции для обработки открытия/закрытия окна сортировки .......\\

        //....... Обработка открытия/закрытия меню .......\\
        document.addEventListener('DOMContentLoaded', function() {
            // Обработка клика по кнопке меню
            document.querySelectorAll('.menu-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
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
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.fixed-menu')) {
                    document.querySelectorAll('.menu-options').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });
        });
        //....... Конец функции для обработки открытия/закрытия меню .......\\

        //....... Обработка чекбокса "Выбрать все" .......\\
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем главный чекбокс
            const selectAllCheckbox = document.getElementById('selectAll');

            // Обработчик изменения главного чекбокса
            selectAllCheckbox.addEventListener('change', function() {
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
                    <td>${row.inventory_number}</td>
                    <td>${row.title || ''}</td>
                    <td>${row.author || ''}</td>
                    <td>${row.publication_year || ''}</td>
                    <td>${row.publisher || ''}</td>
                    <td>${row.isbn || ''}</td>
                    <td>${row.category || ''}</td>
                    <td>${row.total_copies || ''}</td>
                    <td>${row.condition || ''}</td>
                    <td>${row.date_added || ''}</td>
                    <td>${row.note || ''}</td>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Загружаем данные при загрузке страницы
            loadTableData();

            // Обработка добавления новой книги
            const addBookForm = document.getElementById('addBookForm');
            if (addBookForm) {
                addBookForm.addEventListener('submit', async function(e) {
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
            document.addEventListener('click', async function(e) {
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
                sortButton.addEventListener('click', function() {
                    const column = document.getElementById('sortColumn').value;
                    const direction = document.getElementById('sortDirection').value;
                    loadTableData(column, direction);
                });
            }

            // Обработка экспорта
            const exportButton = document.querySelector('.export-button');
            if (exportButton) {
                exportButton.addEventListener('click', function() {
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
                        if (value.trim() !== '') { // Игнорируем пустые значения
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
                    <th data-column="title">Название книги</th>
                    <th data-column="author">Автор(ы)</th>
                    <th data-column="publication_year">Год издания</th>
                    <th data-column="publisher">Издательство</th>
                    <th data-column="isbn">ISBN</th>
                    <th data-column="category">Категория</th>
                    <th data-column="total_copies">Количество экземпляров</th>
                    <th data-column="condition">Состояние</th>
                    <th data-column="date_added">Дата добавления</th>
                    <th data-column="note">Примечание</th>
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