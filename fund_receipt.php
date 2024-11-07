<?php
try {
    $dbPath = __DIR__ . '/database/fund_receipt.db';
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->query("SELECT * FROM fund_receipt ORDER BY record_date DESC");
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
    <title>Книга суммарного учёта (Поступлние в фонд)</title>
    <link rel="stylesheet" href="fund_receipt.css">
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
            </div>
        </aside>
        <main>
            <div class="header">
                <h1 id="header-title">Книга суммарного учёта (Поступлние в фонд)</h1>
                <p id="header-subtitle">N записей</p>
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
                            <th>Дата записи</th>
                            <th>Номер записи</th>
                            <th>Источник поступления</th>
                            <th>№ или дата документа</th>
                            <th>Всего экз.</th>
                            <th>На казахском</th>
                            <th>На других языках</th>
                            <th>Сумма (тг)</th>
                            <th>Всего эл. экз.</th>
                            <th>Эл. на казахском</th>
                            <th>Эл. на других языках</th>
                            <th>Сумма эл. (тг)</th>
                            <th>Примечания</th>
                            <th class="fixed-menu">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Данные будут загружены через JavaScript -->
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
                                <label for="record_date">Дата записи:</label>
                                <input type="date" id="record_date" name="record_date" required>
                            </div>
                            <div>
                                <label for="record_number">Номер записи:</label>
                                <input type="text" id="record_number" name="record_number" required>
                            </div>
                            <div>
                                <label for="source_of_supply">Источник поступления:</label>
                                <input type="text" id="source_of_supply" name="source_of_supply" required>
                            </div>
                            <div>
                                <label for="document_number_or_date">№ или дата сопроводительного документа:</label>
                                <input type="text" id="document_number_or_date" name="document_number_or_date" required>
                            </div>
                            <div>
                                <label for="total_physical_copies">Всего физических экземпляров:</label>
                                <input type="number" id="total_physical_copies" name="total_physical_copies" required min="0">
                            </div>
                            <div>
                                <label for="copies_in_kazakh">Экземпляров на казахском:</label>
                                <input type="number" id="copies_in_kazakh" name="copies_in_kazakh" required min="0">
                            </div>
                            <div>
                                <label for="copies_in_other_languages">Экземпляров на других языках:</label>
                                <input type="number" id="copies_in_other_languages" name="copies_in_other_languages" required min="0">
                            </div>
                            <div>
                                <label for="amount_in_tenge">Сумма (тенге):</label>
                                <input type="number" id="amount_in_tenge" name="amount_in_tenge" required min="0">
                            </div>
                            <div>
                                <label for="amount_in_tiyn">Сумма (тиын):</label>
                                <input type="number" id="amount_in_tiyn" name="amount_in_tiyn" required min="0" max="99">
                            </div>
                            <div>
                                <label for="total_electronic_copies">Всего электронных экземпляров:</label>
                                <input type="number" id="total_electronic_copies" name="total_electronic_copies" required min="0">
                            </div>
                            <div>
                                <label for="electronic_copies_in_kazakh">Электронных экземпляров на казахском:</label>
                                <input type="number" id="electronic_copies_in_kazakh" name="electronic_copies_in_kazakh" required min="0">
                            </div>
                            <div>
                                <label for="electronic_copies_in_other_languages">Электронных экземпляров на других языках:</label>
                                <input type="number" id="electronic_copies_in_other_languages" name="electronic_copies_in_other_languages" required min="0">
                            </div>
                            <div>
                                <label for="electronic_amount_in_tenge">Сумма электронных (тенге):</label>
                                <input type="number" id="electronic_amount_in_tenge" name="electronic_amount_in_tenge" required min="0">
                            </div>
                            <div>
                                <label for="electronic_amount_in_tiyn">Сумма электронных (тиын):</label>
                                <input type="number" id="electronic_amount_in_tiyn" name="electronic_amount_in_tiyn" required min="0" max="99">
                            </div>
                            <div>
                                <label for="notes">Примечания:</label>
                                <textarea id="notes" name="notes"></textarea>
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
        // Функция для безопасного экранирования HTML
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

        // Функция для создания меню в строке таблицы
        function createTableRow(row) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fixed-checkbox">
                    <input type="checkbox" class="row-checkbox">
                </td>
                <td>${escapeHtml(row.record_date)}</td>
                <td>${escapeHtml(row.record_number)}</td>
                <td>${escapeHtml(row.source_of_supply)}</td>
                <td>${escapeHtml(row.document_number_or_date)}</td>
                <td>${escapeHtml(row.total_physical_copies)}</td>
                <td>${escapeHtml(row.copies_in_kazakh)}</td>
                <td>${escapeHtml(row.copies_in_other_languages)}</td>
                <td>${escapeHtml(row.amount_in_tenge)},${String(row.amount_in_tiyn).padStart(2, '0')}</td>
                <td>${escapeHtml(row.total_electronic_copies)}</td>
                <td>${escapeHtml(row.electronic_copies_in_kazakh)}</td>
                <td>${escapeHtml(row.electronic_copies_in_other_languages)}</td>
                <td>${escapeHtml(row.electronic_amount_in_tenge)},${String(row.electronic_amount_in_tiyn).padStart(2, '0')}</td>
                <td>${escapeHtml(row.notes || '')}</td>
                <td class="fixed-menu">
                    <button type="button" class="menu-btn">
                        <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon">
                    </button>
                    <div class="menu-options">
                        <button type="button" class="menu-icon-btn edit-btn" data-record-id="${row.id}">
                            <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon">
                        </button>
                        <button type="button" class="menu-icon-btn delete-btn" data-record-id="${row.id}">
                            <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить" class="menu-icon">
                        </button>
                    </div>
                </td>
            `;
            return tr;
        }

        // Функция загрузки данных таблицы
        async function loadTableData() {
            try {
                const response = await fetch('handlers/get_fund_receipt.php');
                const result = await response.json();

                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';

                if (result.success && Array.isArray(result.data)) {
                    result.data.forEach(row => {
                        tbody.appendChild(createTableRow(row));
                    });
                    updateRecordCount();
                } else {
                    throw new Error(result.error || 'Неверный формат данных');
                }
            } catch (error) {
                console.error('Ошибка загрузки данных:', error);
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = `<tr><td colspan="15" style="text-align: center; color: red;">Ошибка загрузки данных: ${error.message}</td></tr>`;
            }
        }

        // Функция обновления счетчика записей
        function updateRecordCount() {
            const rows = document.querySelector('table tbody').getElementsByTagName('tr');
            const headerSubtitle = document.getElementById('header-subtitle');
            if (headerSubtitle) {
                headerSubtitle.textContent = `${rows.length} записей`;
            }
        }

        // Инициализация при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация навигационного меню
            const navButtons = document.querySelectorAll('.nav-section');
            navButtons.forEach(button => {
                if (button.tagName === 'BUTTON') {
                    button.addEventListener('click', function() {
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
                }
            });

            // Закрытие подменю при клике вне
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.nav-section') && !e.target.closest('.submenu')) {
                    document.querySelectorAll('.submenu').forEach(menu => {
                        menu.style.display = 'none';
                    });
                }
            });

            // Обработчик кнопки добавления новой записи
            const addButton = document.querySelector('.add-book-btn');
            const modal = document.getElementById('addBookModal');
            const closeBtn = modal.querySelector('.close');

            addButton.addEventListener('click', function() {
                modal.style.display = 'block';
                document.getElementById('addBookForm').reset(); // Очищаем форму
            });

            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Закрытие модального окна при клике вне его
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Обработчик формы добавления новой записи
            const addBookForm = document.getElementById('addBookForm');
            addBookForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                try {
                    const formData = new FormData(this);
                    const response = await fetch('handlers/save_fund_receipt.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        modal.style.display = 'none';
                        loadTableData(); // Перезагружаем таблицу
                        alert('Запись успешно сохранена');
                    } else {
                        throw new Error(result.error || 'Ошибка при сохранении');
                    }
                } catch (error) {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при сохранении: ' + error.message);
                }
            });

            // Обработчик клика по документу
            document.addEventListener('click', function(e) {
                const menuBtn = e.target.closest('.menu-btn');
                const menuOptions = e.target.closest('.menu-options');
                
                // Закрываем все меню при клике вне них
                if (!menuBtn && !menuOptions) {
                    document.querySelectorAll('.menu-options').forEach(menu => {
                        menu.classList.remove('active');
                    });
                }
                
                // Открываем/закрываем меню при клике на кнопку
                if (menuBtn) {
                    e.stopPropagation();
                    const currentMenu = menuBtn.nextElementSibling;
                    
                    // Закрываем все другие меню
                    document.querySelectorAll('.menu-options').forEach(menu => {
                        if (menu !== currentMenu) {
                            menu.classList.remove('active');
                        }
                    });
                    
                    // Переключаем текущее меню
                    currentMenu.classList.toggle('active');
                }
            });

            // бработчики кнпок редактирования и удаления
            document.addEventListener('click', function(e) {
                if (e.target.closest('.edit-btn')) {
                    e.stopPropagation();
                    const recordId = e.target.closest('.edit-btn').getAttribute('data-record-id');
                    if (recordId) {
                        editRecord(recordId);
                    }
                }
                
                if (e.target.closest('.delete-btn')) {
                    e.stopPropagation();
                    const recordId = e.target.closest('.delete-btn').getAttribute('data-record-id');
                    if (recordId) {
                        deleteRecord(recordId);
                    }
                }
            });

            // Функция редактирования записи
            async function editRecord(id) {
                try {
                    const response = await fetch(`handlers/get_fund_receipt_record.php?id=${id}`);
                    const result = await response.json();

                    if (result.success) {
                        const record = result.data;
                        const form = document.getElementById('addBookForm');
                        
                        // Заполняем форму данными
                        form.record_date.value = record.record_date;
                        form.record_number.value = record.record_number;
                        form.source_of_supply.value = record.source_of_supply;
                        form.document_number_or_date.value = record.document_number_or_date;
                        form.total_physical_copies.value = record.total_physical_copies;
                        form.copies_in_kazakh.value = record.copies_in_kazakh;
                        form.copies_in_other_languages.value = record.copies_in_other_languages;
                        form.amount_in_tenge.value = record.amount_in_tenge;
                        form.amount_in_tiyn.value = record.amount_in_tiyn;
                        form.total_electronic_copies.value = record.total_electronic_copies;
                        form.electronic_copies_in_kazakh.value = record.electronic_copies_in_kazakh;
                        form.electronic_copies_in_other_languages.value = record.electronic_copies_in_other_languages;
                        form.electronic_amount_in_tenge.value = record.electronic_amount_in_tenge;
                        form.electronic_amount_in_tiyn.value = record.electronic_amount_in_tiyn;
                        form.notes.value = record.notes || '';

                        // Добавляем ID записи в скрытое поле
                        let idInput = form.querySelector('input[name="id"]');
                        if (!idInput) {
                            idInput = document.createElement('input');
                            idInput.type = 'hidden';
                            idInput.name = 'id';
                            form.appendChild(idInput);
                        }
                        idInput.value = id;

                        // Показываем модальное окно
                        document.getElementById('addBookModal').style.display = 'block';
                    } else {
                        throw new Error(result.error || 'Ошибка при получении данных записи');
                    }
                } catch (error) {
                    console.error('Ошибка при редактировании записи:', error);
                    alert('Произошла ошибка при редактировании записи: ' + error.message);
                }
            }

            // Инициализация таблицы при загрузке страницы
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
                    // Пропускаем строку, если она содержит сообщение об ошибке
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
                updateRecordCount(true);
            });

            // Обновляем функцию подсчета записей
            function updateRecordCount(isSearch = false) {
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
                        headerSubtitle.textContent = `Найдено ${visibleCount} из ${totalCount} записей`;
                    } else {
                        headerSubtitle.textContent = `${visibleCount} записей`;
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
            searchInput.style.margin
        });
    </script>
</body>

</html>