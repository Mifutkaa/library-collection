<?php
try {
    $dbPath = __DIR__ . '/database/lib_record.db';
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из таблицы
    $stmt = $db->query("SELECT * FROM lib_record");
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
    <title>Ведомость учёта библиотечного фонда</title>
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
                <h1 id="header-title">Ведомость учёта библиотечного фонда</h1>
                <p id="header-subtitle">N книг</p>
            </div>

            <div class="controls">
                <div class="dropdown">
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
                                <label for="quantity">Количество:</label>
                                <input type="number" id="quantity" name="quantity" required>
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
                                <input type="checkbox" id="selectAll" class="select-all-checkbox">
                            </th>
                            <th>Название книги</th>
                            <th>Автор(ы)</th>
                            <th>Год издания</th>
                            <th>Издательство</th>
                            <th>ISBN</th>
                            <th>Количество</th>
                            <th>Состояние</th>
                            <th class="fixed-menu">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($records)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Нет доступных записей</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($records as $row): ?>
                                <tr>
                                    <td class="fixed-checkbox">
                                        <input type="checkbox" class="row-checkbox">
                                    </td>
                                    <td><?= htmlspecialchars($row['title'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['authors'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['publication_year'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['publisher'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['ISBN'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['quantity'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['condition'] ?? '') ?></td>
                                    <td class="fixed-menu">
                                        <button class="menu-btn">
                                            <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon" title="Меню">
                                        </button>
                                        <div class="menu-options">
                                            <button class="menu-icon-btn edit-btn" data-id="<?= htmlspecialchars($row['ISBN']) ?>">
                                                <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon" title="Редактировать">
                                            </button>
                                            <button class="menu-icon-btn delete-btn" data-id="<?= htmlspecialchars($row['ISBN']) ?>">
                                                <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить" class="menu-icon" title="Удалить">
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="assets/js/database-handler.js"></script>
    <script src="assets/js/ui-handler.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Инициализация таблицы (убрали createTableHeader)
            loadTableData();

            // Обработчик открытия модального окна
            document.querySelector('.add-book-btn').addEventListener('click', function() {
                document.getElementById('addBookModal').style.display = 'block';
            });

            // Обработчик закрытия модального окна
            document.querySelector('.close').addEventListener('click', function() {
                document.getElementById('addBookModal').style.display = 'none';
            });

            // Закрытие модального окна при клике вне его
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('addBookModal');
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Обработчик отправки формы
            document.getElementById('addBookForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                try {
                    const formData = new FormData(this);
                    const data = {};

                    formData.forEach((value, key) => {
                        // Сохраняем все значения, даже пустые
                        data[key] = value.trim();
                    });

                    if (!data.inventory_number) {
                        alert('Пожалуйста, заполните инвентарный номер');
                        return;
                    }

                    // Определяем, это новая запись или редактирование
                    const isEdit = this.dataset.editId !== undefined;
                    const url = isEdit ? 'api/update_record.php' : 'api/add_record.php';

                    if (isEdit) {
                        data.original_inventory_number = this.dataset.editId;
                    }

                    console.log('Отправляемые данные:', data); // Для отладки

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.error || `HTTP error! status: ${response.status}`);
                    }

                    if (result.success) {
                        alert(isEdit ? 'Запись успешно обновлена!' : 'Запись успешно добавлена!');

                        // Закрываем модальное окно
                        document.getElementById('addBookModal').style.display = 'none';

                        // Очищаем форму и удаляем ID редактируемой записи
                        this.reset();
                        delete this.dataset.editId;

                        // Возвращаем заголовок модального окна
                        const modalTitle = document.querySelector('#addBookModal .modal-title');
                        if (modalTitle) {
                            modalTitle.textContent = 'Добавить новую запись';
                        }

                        // Обновляем таблицу
                        await loadTableData();
                    } else {
                        throw new Error(result.error || 'Неизвестная ошибка');
                    }

                } catch (error) {
                    console.error('Ошибка:', error);
                    alert(`Ошибка: ${error.message}`);
                }
            });

            // Обработчик чекбокса "Выбрать все"
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const rowCheckboxes = document.querySelectorAll('table tbody .row-checkbox');
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });
            }

            // Обработка меню для каждой записи
            document.addEventListener('click', function(e) {
                // Если клик был по кнопке меню
                if (e.target.closest('.menu-btn')) {
                    e.stopPropagation();

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

            // Обработчик кнопок удаления
            document.addEventListener('click', async function(e) {
                const deleteBtn = e.target.closest('.delete-btn');
                if (deleteBtn) {
                    const id = deleteBtn.dataset.id;

                    if (confirm('Вы уверены, что хотите удалить эту запись?')) {
                        try {
                            const response = await fetch('api/delete_record.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    inventory_number: id
                                })
                            });

                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }

                            const result = await response.json();

                            if (result.success) {
                                // Обновляем таблицу после успешного удаления
                                loadTableData();
                                alert('Запись успешно удалена');
                            } else {
                                throw new Error(result.error || 'Ошибка при удалении записи');
                            }
                        } catch (error) {
                            console.error('Ошибка:', error);
                            alert(`Ошибка при удалении: ${error.message}`);
                        }
                    }
                }
            });

            // Обработчик кнопок редактирования
            document.addEventListener('click', async function(e) {
                const editBtn = e.target.closest('.edit-btn');
                if (editBtn) {
                    const id = editBtn.dataset.id;
                    try {
                        // Получаем данные записи
                        const response = await fetch(`api/get_record.php?id=${id}`);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const result = await response.json();
                        if (result.success) {
                            // Заполняем форму данными
                            const form = document.getElementById('addBookForm');
                            for (const [key, value] of Object.entries(result.data)) {
                                const input = form.querySelector(`[name="${key}"]`);
                                if (input) {
                                    input.value = value || '';
                                }
                            }

                            // Меняем заголовок модального окна
                            const modalTitle = document.querySelector('#addBookModal .modal-title');
                            if (modalTitle) {
                                modalTitle.textContent = 'Редактировать запись';
                            }

                            // Добавляем ID редактируемой записи
                            form.dataset.editId = id;

                            // Открываем модальное окно
                            document.getElementById('addBookModal').style.display = 'block';
                        } else {
                            throw new Error(result.error || 'Ошибка получения данных');
                        }
                    } catch (error) {
                        console.error('Ошибка:', error);
                        alert(`Ошибка при загрузке данных: ${error.message}`);
                    }
                }
            });

            // Обновляем обработчик отправки формы для поддержки редактирования
            document.getElementById('addBookForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                try {
                    const formData = new FormData(this);
                    const data = {};

                    formData.forEach((value, key) => {
                        if (value.trim() !== '') {
                            data[key] = value.trim();
                        }
                    });

                    if (!data.inventory_number) {
                        alert('Пожалуйста, заполните инвентарный номер');
                        return;
                    }

                    // Определяем, это новая запись или редактирование
                    const isEdit = this.dataset.editId !== undefined;
                    const url = isEdit ? 'api/update_record.php' : 'api/add_record.php';

                    if (isEdit) {
                        data.original_inventory_number = this.dataset.editId;
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.success) {
                        alert(isEdit ? 'Запись успешно обновлена!' : 'Запись успешно добавлена!');

                        // Закрываем модальное окно
                        document.getElementById('addBookModal').style.display = 'none';

                        // Очищаем форму и удаляем ID редактируемой записи
                        this.reset();
                        delete this.dataset.editId;

                        // Возвращаем заголовок модального окна
                        const modalTitle = document.querySelector('#addBookModal .modal-title');
                        if (modalTitle) {
                            modalTitle.textContent = 'Добавить новую запись';
                        }

                        // Обновляем таблицу
                        loadTableData();

                    } else {
                        throw new Error(result.error || 'Ошибка при сохранении записи');
                    }

                } catch (error) {
                    console.error('Ошибка:', error);
                    alert(`Ошибка: ${error.message}`);
                }
            });

            // Обновляем обработчик поиска, чтобы сохранять отфильтрованные записи
            let filteredRows = []; // Глобальная переменная для хранения отфильтрованных строк

            // Обработчик поиска
            searchInput.addEventListener('input', function(e) {
                const searchText = e.target.value.toLowerCase();
                const tbody = document.querySelector('table tbody');
                const rows = tbody.getElementsByTagName('tr');

                filteredRows = []; // Очищаем массив

                for (let row of rows) {
                    let found = false;
                    const cells = row.getElementsByTagName('td');
                    for (let i = 0; i < cells.length - 1; i++) {
                        const cellText = cells[i].textContent.toLowerCase();
                        if (cellText.includes(searchText)) {
                            found = true;
                            break;
                        }
                    }
                    // Показываем или скрываем строку
                    row.style.display = found ? '' : 'none';
                }

                // Обновляем счетчик видимых записей
                updateBookCount(true);
            });

            // Обновляем функцию подсчета записей
            function updateBookCount(isSearch = false) {
                const tbody = document.querySelector('table tbody');
                const rows = tbody.getElementsByTagName('tr');
                let visibleCount = 0;

                for (let row of rows) {
                    if (row.style.display !== 'none') {
                        visibleCount++;
                    }
                }

                const headerSubtitle = document.getElementById('header-subtitle');
                if (headerSubtitle) {
                    if (isSearch) {
                        const totalCount = rows.length;
                        headerSubtitle.textContent = `Найдено ${visibleCount} из ${totalCount} книг`;
                    } else {
                        headerSubtitle.textContent = `${visibleCount} книг`;
                    }
                }
            }

            // Добавляем стили для поля поиска
            searchInput.style.padding = '8px';
            searchInput.style.border = '1px solid #ddd';
            searchInput.style.borderRadius = '4px';
            searchInput.style.marginBottom = '10px';
            searchInput.style.width = '200px';

            // Добавляем очистку поиска при нажатии Escape
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    this.dispatchEvent(new Event('input'));
                }
            });

            // Добавляем иконку поиска
            const searchWrapper = document.createElement('div');
            searchWrapper.style.position = 'relative';
            searchWrapper.style.display = 'inline-block';

            const searchIcon = document.createElement('img');
            searchIcon.src = './img/search-ico.svg'; // Убедитесь, что путь к иконке правильный
            searchIcon.style.position = 'absolute';
            searchIcon.style.right = '10px';
            searchIcon.style.top = '50%';
            searchIcon.style.transform = 'translateY(-50%)';
            searchIcon.style.width = '16px';
            searchIcon.style.height = '16px';
            searchIcon.style.opacity = '0.5';

            // Оборачиваем input в контейнер с иконкой
            searchInput.parentNode.insertBefore(searchWrapper, searchInput);
            searchWrapper.appendChild(searchInput);
            searchWrapper.appendChild(searchIcon);

            // Добавляем placeholder с подсказкой
            searchInput.placeholder = 'Поиск по всем полям...';

            // Добавляем кнопку очистки
            const clearButton = document.createElement('button');
            clearButton.innerHTML = '×';
            clearButton.style.position = 'absolute';
            clearButton.style.right = '30px';
            clearButton.style.top = '50%';
            clearButton.style.transform = 'translateY(-50%)';
            clearButton.style.border = 'none';
            clearButton.style.background = 'none';
            clearButton.style.fontSize = '18px';
            clearButton.style.color = '#999';
            clearButton.style.cursor = 'pointer';
            clearButton.style.display = 'none';
            clearButton.title = 'Очистить поиск';

            searchWrapper.appendChild(clearButton);

            // Показываем/скрываем кнопку очистки
            searchInput.addEventListener('input', function() {
                clearButton.style.display = this.value ? 'block' : 'none';
            });

            // Обработчик клика по кнопке очистки
            clearButton.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                this.style.display = 'none';
                searchInput.focus();
            });

            // Обработчик кнопки экспорта
            document.querySelector('.export-button').addEventListener('click', async function() {
                try {
                    // Показываем индикатор загрузки
                    this.disabled = true;
                    this.innerHTML = '<img src="./img/loading.gif" alt="Загрузка..." class="button-icon">Экспорт...';

                    const response = await fetch('api/export_excel.php');

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    // Получаем blob из ответа
                    const blob = await response.blob();

                    // Создаем ссылку для скачивания
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `book_arrival_${new Date().toISOString().split('T')[0]}.xlsx`;

                    // Добавляем ссылку на страницу и эмулируем клик
                    document.body.appendChild(a);
                    a.click();

                    // Удаляем ссылку
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);

                } catch (error) {
                    console.error('Ошибка экспорта:', error);
                    alert(`Ошибка при экспорте: ${error.message}`);
                } finally {
                    // Возвращаем кнопку в исходное состояние
                    this.disabled = false;
                    this.innerHTML = '<img src="./img/ico-export.svg" alt="Иконка экспорта" class="button-icon">Экспортировать';
                }
            });
        });

        // Функция загрузки данных таблицы
        async function loadTableData() {
            try {
                const response = await fetch('handlers/get_lib_records.php');
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
                            <td>${escapeHtml(row.quantity)}</td>
                            <td>${escapeHtml(row.condition)}</td>
                            <td class="fixed-menu">
                                <button class="menu-btn">
                                    <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon">
                                </button>
                                <div class="menu-options">
                                    <button class="menu-icon-btn edit-btn" data-id="${escapeHtml(row.ISBN)}">
                                        <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon">
                                    </button>
                                    <button class="menu-icon-btn delete-btn" data-id="${escapeHtml(row.ISBN)}">
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
                tbody.innerHTML = `<tr><td colspan="9" style="text-align: center; color: red;">Ошибка загрузки данных: ${error.message}</td></tr>`;
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
