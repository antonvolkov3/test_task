<?php

$array = [
    ["id" => 1, "date" => "12.01.2020", "name" => "test1"],
    ["id" => 2, "date" => "02.05.2020", "name" => "test2"],
    ["id" => 4, "date" => "08.03.2020", "name" => "test4"],
    ["id" => 1, "date" => "22.01.2020", "name" => "test1"],
    ["id" => 2, "date" => "11.11.2020", "name" => "test4"],
    ["id" => 3, "date" => "06.06.2020", "name" => "test3"],
];
echo 'Начальный массив:<br /><pre>';
print_r($array);
echo '</pre><br />1. выделить уникальные записи (убрать дубли) в отдельный массив. в конечном массиве не должно быть элементов с одинаковым id.<br /><pre>';

//1. выделить уникальные записи (убрать дубли) в отдельный массив. в конечном массиве не должно быть элементов с одинаковым id.
$uniqueIds = array_unique(array_column($array, 'id'), SORT_REGULAR);
$uniqueIdsKeys = array_keys($uniqueIds);
$uniqueArray = array_filter($array, function($item) use ($uniqueIdsKeys) {
    return in_array($item, $uniqueIdsKeys);
}, ARRAY_FILTER_USE_KEY);
print_r($uniqueArray);
echo '</pre><br />2. отсортировать многомерный массив по ключу (любому) - id<br /><pre>';

//2. отсортировать многомерный массив по ключу (любому)
function arraySort($a, $b) {
    return $a['id'] - $b['id'];
}
usort($uniqueArray, 'arraySort');
print_r($uniqueArray);
echo '</pre><br />3. вернуть из массива только элементы, удовлетворяющие внешним условиям (например элементы с определенным id) - 1, 3<br /><pre>';

//3. вернуть из массива только элементы, удовлетворяющие внешним условиям (например элементы с определенным id)
$allowIds = [1, 3];
$arrayFilter = array_filter($uniqueArray, function($item) use ($allowIds) {
    return in_array($item['id'], $allowIds);
});
print_r($arrayFilter);
echo '</pre><br />4. изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение)<br /><pre>';

//4. изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение)
$newArray = array_combine(
    array_column($uniqueArray, "name"),
    array_column($uniqueArray, "id")
);
print_r($newArray);
echo '</pre><br />';

//5. В базе данных имеется таблица с товарами goods (id INTEGER, name TEXT), таблица с тегами tags (id INTEGER, name TEXT) и таблица связи товаров и тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id, goods_id)). Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.
$query = "
    SELECT g.id, g.name
    FROM goods g
    WHERE NOT EXISTS (
        SELECT t.id 
        FROM tags t
        WHERE NOT EXISTS (
            SELECT gt.tag_id 
            FROM goods_tags gt
            WHERE gt.tag_id = t.id 
                AND gt.goods_id = g.id
        )
    );
";
echo '5. В базе данных имеется таблица с товарами goods (id INTEGER, name TEXT), таблица с тегами tags (id INTEGER, name TEXT) и таблица связи товаров и тегов goods_tags (tag_id INTEGER, goods_id INTEGER, UNIQUE(tag_id, goods_id)). Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.<br /><pre>' . $query . '</pre><br />';

//6. Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины, и все они (каждый) поставили высокую оценку (строго выше 5).
$query = "
    SELECT department_id
    FROM evaluations
    WHERE gender = true 
      AND value > 5
    GROUP BY department_id;
";
echo '6. Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины, и все они (каждый) поставили высокую оценку (строго выше 5).<br /><pre>' . $query . '</pre>';