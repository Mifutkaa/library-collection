<?php
// В начале файла добавьте подключение к БД
try {
    $dbPath = __DIR__ . '/database/book_arrival.db';
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем данные из таблицы
    $stmt = $db->query("SELECT * FROM book_arrival");
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
                <h1 id="header-title">Приход книг</h1>
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
                            <th>Навание издания</th>
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
                            <th>Инекс ГРНТИ</th>
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
                        <?php if (empty($records)): ?>
                            <tr>
                                <td colspan="43" class="text-center">Нет доступных записей</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($records as $row): ?>
                                <tr>
                                    <td class="fixed-checkbox"><input type="checkbox" class="row-checkbox"></td>
                                    <td><?= htmlspecialchars($row['inventory_number'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['inventory_date'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['publication_type'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['authors'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['second_author'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['third_author'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['responsibility_info'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['title'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['title_related_info'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['publication_info'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['series'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['material_type'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['publication_place'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['publisher'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['year_of_publication'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['page_count'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['printed_sheets'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['mark'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['isbn'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['country'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['copies'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['price'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['edition_copies'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['category'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['keywords'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['bbk_index'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['udc_index'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['grnti_index'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['author_sign'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['language'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['summary'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['notes'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['illustrations'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['binding'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['verification_mark_1'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['verification_mark_2'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['verification_mark_3'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['sigla'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['organization_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['html_link'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['physical_characteristics'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['system_requirements'] ?? '') ?></td>
                                    <td class="fixed-menu">
                                        <button class="menu-btn">
                                            <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon" title="Меню">
                                        </button>
                                        <div class="menu-options">
                                            <button class="menu-icon-btn edit-btn" data-id="<?= htmlspecialchars($row['inventory_number']) ?>">
                                                <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon" title="Редактировать">
                                            </button>
                                            <button class="menu-icon-btn delete-btn" data-id="<?= htmlspecialchars($row['inventory_number']) ?>">
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
            // Инициализация переменной searchInput
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
                    // Пропускаем строку, если она содержит сообщение об отсутствии данных
                    if (row.cells.length === 1 && row.cells[0].getAttribute('colspan')) {
                        return;
                    }

                    let found = false;
                    // Начинаем с индекса 1, чтобы пропустить чекбокс
                    for (let i = 1; i < row.cells.length - 1; i++) {
                        const cellText = row.cells[i].textContent.toLowerCase();
                        if (cellText.includes(searchText)) {
                            found = true;
                            break;
                        }
                    }
                    row.style.display = found ? '' : 'none';
                });

                // Обновляем счетчик
                updateBookCount(true);
            });

            // Функция обновления счетчика
            function updateBookCount(isSearch = false) {
                const tbody = document.querySelector('table tbody');
                const rows = tbody.getElementsByTagName('tr');
                let visibleCount = 0;

                Array.from(rows).forEach(row => {
                    // Пропускаем строку с сообщением об отсутствии данных
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

            // Добавляем стили для поля поиска
            searchInput.style.padding = '8px 30px 8px 8px'; // Увеличиваем правый padding для иконок
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

            // Обновляем placeholder
            searchInput.placeholder = 'Поиск по всем полям...';

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
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '<tr><td colspan="43" style="text-align: center;">Загрузка данных...</td></tr>';

                const response = await fetch('api/database.php');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success && Array.isArray(result.data)) {
                    tbody.innerHTML = '';

                    if (result.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="43" style="text-align: center;">Нет данных</td></tr>';
                        updateBookCount();
                        return;
                    }

                    result.data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="fixed-checkbox"><input type="checkbox" class="row-checkbox"></td>
                            <td>${escapeHtml(row.inventory_number || '')}</td>
                            <td>${escapeHtml(row.inventory_date || '')}</td>
                            <td>${escapeHtml(row.publication_type || '')}</td>
                            <td>${escapeHtml(row.authors || '')}</td>
                            <td>${escapeHtml(row.second_author || '')}</td>
                            <td>${escapeHtml(row.third_author || '')}</td>
                            <td>${escapeHtml(row.responsibility_info || '')}</td>
                            <td>${escapeHtml(row.title || '')}</td>
                            <td>${escapeHtml(row.title_related_info || '')}</td>
                            <td>${escapeHtml(row.publication_info || '')}</td>
                            <td>${escapeHtml(row.series || '')}</td>
                            <td>${escapeHtml(row.material_type || '')}</td>
                            <td>${escapeHtml(row.publication_place || '')}</td>
                            <td>${escapeHtml(row.publisher || '')}</td>
                            <td>${escapeHtml(row.year_of_publication || '')}</td>
                            <td>${escapeHtml(row.page_count || '')}</td>
                            <td>${escapeHtml(row.printed_sheets || '')}</td>
                            <td>${escapeHtml(row.mark || '')}</td>
                            <td>${escapeHtml(row.isbn || '')}</td>
                            <td>${escapeHtml(row.country || '')}</td>
                            <td>${escapeHtml(row.copies || '')}</td>
                            <td>${escapeHtml(row.price || '')}</td>
                            <td>${escapeHtml(row.edition_copies || '')}</td>
                            <td>${escapeHtml(row.category || '')}</td>
                            <td>${escapeHtml(row.keywords || '')}</td>
                            <td>${escapeHtml(row.bbk_index || '')}</td>
                            <td>${escapeHtml(row.udc_index || '')}</td>
                            <td>${escapeHtml(row.grnti_index || '')}</td>
                            <td>${escapeHtml(row.author_sign || '')}</td>
                            <td>${escapeHtml(row.language || '')}</td>
                            <td>${escapeHtml(row.summary || '')}</td>
                            <td>${escapeHtml(row.notes || '')}</td>
                            <td>${escapeHtml(row.illustrations || '')}</td>
                            <td>${escapeHtml(row.binding || '')}</td>
                            <td>${escapeHtml(row.verification_mark_1 || '')}</td>
                            <td>${escapeHtml(row.verification_mark_2 || '')}</td>
                            <td>${escapeHtml(row.verification_mark_3 || '')}</td>
                            <td>${escapeHtml(row.sigla || '')}</td>
                            <td>${escapeHtml(row.organization_name || '')}</td>
                            <td>${escapeHtml(row.html_link || '')}</td>
                            <td>${escapeHtml(row.physical_characteristics || '')}</td>
                            <td>${escapeHtml(row.system_requirements || '')}</td>
                            <td class="fixed-menu">
                                <button class="menu-btn">
                                    <img src="./img/library-dashboard/menu-ico.svg" alt="Меню" class="menu-icon" title="Меню">
                                </button>
                                <div class="menu-options">
                                    <button class="menu-icon-btn edit-btn" data-id="${escapeHtml(row.inventory_number)}">
                                        <img src="./img/library-dashboard/edit-ico.svg" alt="Редактировать" class="menu-icon" title="Редактировать">
                                    </button>
                                    <button class="menu-icon-btn delete-btn" data-id="${escapeHtml(row.inventory_number)}">
                                        <img src="./img/library-dashboard/delete-ico.svg" alt="Удалить" class="menu-icon" title="Удалить">
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
                tbody.innerHTML = `<tr><td colspan="43" style="text-align: center; color: red;">Ошибка загрузки данных: ${error.message}</td></tr>`;
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