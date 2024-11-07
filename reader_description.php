<?php
try {
    $dbPath = __DIR__ . '/database/readers.db';
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из таблицы readers
    $stmt = $db->query("SELECT * FROM readers");
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
    <title>Читатели</title>
    <link rel="stylesheet" href="reader_description.css">
</head>

<body>
    <div class="container">
        <aside class="sidebar">

            <a href="index.html" class="nav-section">Главная</a>

            <button class="nav-section">Документы</button>
            <div id="documents" class="submenu">
                <a href="book_arrival.php">Приход книг</a>
                <a href="reader_description.php" class="active">Читатели</a>
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
                <h1 id="header-title">Читатели</h1>
                <p id="header-subtitle">N читателей</p>
            </div>

            <div class="controls">
                <div class="dropdown">
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
                    <button class="button-action export-btn"><img src="./img/ico-export.svg" alt="Иконка экспорта"
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
                            <th data-column="full_name">ФИО</th>
                            <th data-column="birth_date">Дата рождения</th>
                            <th data-column="nationality">Национальность</th>
                            <th data-column="phone">Телефон</th>
                            <th data-column="email">Email</th>
                            <th data-column="student_id">№ студ. билета</th>
                            <th data-column="course">Курс</th>
                            <th data-column="groups">Группа</th>
                            <th data-column="borrowed_books">Список книг</th>
                            <th data-column="debt">Задолженность</th>
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
                    <h2>Добавить читателя</h2>
                    <form id="addBookForm">
                        <div class="form-grid">
                            <div>
                                <label for="full_name">ФИО:</label>
                                <input type="text" id="full_name" name="full_name" required>
                            </div>
                            <div>
                                <label for="birth_date">Дата рождения:</label>
                                <input type="date" id="birth_date" name="birth_date" required>
                            </div>
                            <div>
                                <label for="nationality">Национальность:</label>
                                <input type="text" id="nationality" name="nationality" required>
                            </div>
                            <div>
                                <label for="phone">Телефон:</label>
                                <input type="tel" id="phone" name="phone" required pattern="\+7-[0-9]{3}-[0-9]{3}-[0-9]{4}">
                            </div>
                            <div>
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email">
                            </div>
                            <div>
                                <label for="student_id">№ студенческого билета:</label>
                                <input type="text" id="student_id" name="student_id" required>
                            </div>
                            <div>
                                <label for="course">Курс:</label>
                                <select id="course" name="course" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div>
                                <label for="groups">Группа:</label>
                                <input type="text" id="groups" name="groups" required>
                            </div>
                            <div>
                                <label for="borrowed_books">Список взятых книг:</label>
                                <textarea id="borrowed_books" name="borrowed_books"></textarea>
                            </div>
                            <div>
                                <label for="debt">Задолженность:</label>
                                <select id="debt" name="debt">
                                    <option value="0">Нет</option>
                                    <option value="1">Есть</option>
                                </select>
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
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = '';

            // Используем JSON.stringify для безопасного преобразования PHP данных в JavaScript
            const records = <?php echo json_encode($records, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

            records.forEach(record => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="fixed-checkbox">
                        <input type="checkbox" class="row-checkbox">
                    </td>
                    <td>${record.full_name || ''}</td>
                    <td>${record.birth_date || ''}</td>
                    <td>${record.nationality || ''}</td>
                    <td>${record.phone || ''}</td>
                    <td>${record.email || ''}</td>
                    <td>${record.student_id || ''}</td>
                    <td>${record.course || ''}</td>
                    <td>${record.groups || ''}</td>
                    <td>${record.borrowed_books || ''}</td>
                    <td>${record.debt ? 'Есть' : 'Нет'}</td>
                    <td class="fixed-menu">
                        <button class="menu-btn">
                            <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon">
                        </button>
                        <div class="menu-options">
                            <button class="menu-icon-btn edit-btn" data-id="${record.id}">
                                <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon">
                            </button>
                            <button class="menu-icon-btn delete-btn" data-id="${record.id}">
                                <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить" class="menu-icon">
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            // Обновляем счетчик
            updateBookCount();

            // Обработчик кнопки "Добавить новую запись"
            const addButton = document.querySelector('.add-book-btn');
            if (addButton) {
                addButton.addEventListener('click', function() {
                    const modal = document.getElementById('addBookModal');
                    if (modal) {
                        modal.style.display = 'block';
                    }
                });
            }

            // Обработчик закрытия модального окна
            const closeButton = document.querySelector('.close');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    const modal = document.getElementById('addBookModal');
                    if (modal) {
                        modal.style.display = 'none';
                    }
                });
            }

            // Обработчик формы добавления/редактирования
            const addBookForm = document.getElementById('addBookForm');
            if (addBookForm) {
                addBookForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    try {
                        const formData = new FormData(this);
                        const response = await fetch('handlers/save_reader.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();
                        
                        if (result.success) {
                            document.getElementById('addBookModal').style.display = 'none';
                            location.reload(); // Перезагружаем страницу
                        } else {
                            throw new Error(result.error || 'Ошибка при сохранении');
                        }
                    } catch (error) {
                        console.error('Ошибка:', error);
                        alert('Произошла ошибка при сохранении данных: ' + error.message);
                    }
                });
            }

            // Обработчики кнопок редактирования
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', async function() {
                    const id = this.dataset.id;
                    try {
                        const response = await fetch(`handlers/get_reader.php?id=${id}`);
                        const data = await response.json();
                        
                        // Заполняем форму данными
                        Object.keys(data).forEach(key => {
                            const input = document.getElementById(key);
                            if (input) {
                                input.value = data[key];
                            }
                        });

                        // Показываем модальное окно
                        const modal = document.getElementById('addBookModal');
                        if (modal) {
                            modal.style.display = 'block';
                        }
                    } catch (error) {
                        console.error('Ошибка:', error);
                        alert('Ошибка при загрузке данных');
                    }
                });
            });

            // Обработчики кнопок удаления
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', async function() {
                    if (confirm('Вы уверены, что хотите удалить эту запись?')) {
                        const id = this.dataset.id;
                        try {
                            const response = await fetch(`handlers/delete_reader.php?id=${id}`, {
                                method: 'DELETE'
                            });
                            
                            if (response.ok) {
                                location.reload(); // Перезагружаем страницу после успешного удаления
                            } else {
                                throw new Error('Ошибка при удалении');
                            }
                        } catch (error) {
                            console.error('Ошибка:', error);
                            alert('Произошла ошибка при удалении записи');
                        }
                    }
                });
            });

            // Обработчик кнопки экспорта
            const exportButton = document.querySelector('.export-btn');
            if (exportButton) {
                exportButton.addEventListener('click', async function() {
                    try {
                        const response = await fetch('handlers/export_readers.php');
                        const blob = await response.blob();
                        
                        // Создаем ссылку для скачивания
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'readers_export.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    } catch (error) {
                        console.error('Ошибка:', error);
                        alert('Произошла ошибка при экспорте данных');
                    }
                });
            }

            // Обработчики для навигационной панели
            const navButtons = document.querySelectorAll('.nav-section');
            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Если это кнопка с подменю
                    const submenu = this.nextElementSibling;
                    if (submenu && submenu.classList.contains('submenu')) {
                        // Закрываем все остальные подменю
                        document.querySelectorAll('.submenu').forEach(menu => {
                            if (menu !== submenu) {
                                menu.style.display = 'none';
                            }
                        });
                        // Переключаем текущее подменю
                        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                    }
                });
            });

            // Закрытие подменю при клике вне навигации
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.sidebar')) {
                    document.querySelectorAll('.submenu').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });
        });

        // Функция обновления счетчика
        function updateBookCount() {
            const rows = document.querySelector('table tbody').getElementsByTagName('tr');
            document.getElementById('header-subtitle').textContent = `${rows.length} читателей`;
        }

        // Обработчики для кнопок меню
        document.addEventListener('click', function(e) {
            const menuBtn = e.target.closest('.menu-btn');
            if (menuBtn) {
                e.stopPropagation();
                const menuOptions = menuBtn.nextElementSibling;
                // Закрываем все открытые меню
                document.querySelectorAll('.menu-options').forEach(menu => {
                    if (menu !== menuOptions) {
                        menu.style.display = 'none';
                    }
                });
                // Переключаем текущее меню
                menuOptions.style.display = menuOptions.style.display === 'block' ? 'none' : 'block';
            }
            // Закрываем меню при клике вне его
            else if (!e.target.closest('.menu-options')) {
                document.querySelectorAll('.menu-options').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });

        // Обработчик сортировки
        const sortDropdown = document.querySelector('.sort-dropdown');
        const sortButton = document.querySelector('.dropdown-button');

        if (sortButton && sortDropdown) {
            sortButton.addEventListener('click', function(e) {
                e.stopPropagation();
                sortDropdown.style.display = sortDropdown.style.display === 'block' ? 'none' : 'block';
            });

            // Закрытие сортировки при клике вне
            document.addEventListener('click', function(e) {
                if (!sortDropdown.contains(e.target) && !sortButton.contains(e.target)) {
                    sortDropdown.style.display = 'none';
                }
            });
        }

        // Функция поиска
        function searchTable(searchText) {
            const tbody = document.querySelector('table tbody');
            const rows = tbody.getElementsByTagName('tr');
            const searchLower = searchText.toLowerCase();

            for (let row of rows) {
                let found = false;
                // Пропускаем первую ячейку (чекбокс) и последнюю (меню)
                const cells = Array.from(row.getElementsByTagName('td')).slice(1, -1);
                
                for (let cell of cells) {
                    const text = cell.textContent || cell.innerText;
                    if (text.toLowerCase().includes(searchLower)) {
                        found = true;
                        break;
                    }
                }
                
                row.style.display = found ? '' : 'none';
            }

            // Обновляем счетчик видимых записей
            updateBookCount();
        }

        // Добавляем обработчик для поля поиска
        const searchInput = document.querySelector('.controls input[type="text"]');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                searchTable(e.target.value);
            });
        }

        // Обновляем функцию подсчета записей
        function updateBookCount() {
            const rows = document.querySelector('table tbody').getElementsByTagName('tr');
            const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
            document.getElementById('header-subtitle').textContent = `${visibleRows.length} читателей`;
        }

        function editRecord(id) {
            // ... существующий код ...
            form.groups.value = record.groups;  // Изменено с group на groups
            // ... остальной код ...
        }
    </script>
</body>

</html>
