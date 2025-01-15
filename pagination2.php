<style>

    a{
        margin-inline: 30px;
        text-decoration: none;
    }
    
    .active{margin-top:80px;
        background:gray;
        padding:10px 10px;
        margin-inline:20px;
        color:white
    }
</style>

<?php

include('admin/settings/database.php');


$limit = 5;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = intval($_GET['page']) - 1;
} else {
    $page = 0; 
}

$offset = $page * $limit;


$select = "SELECT * FROM itembox LIMIT :offset, :limit";
$pdox = $pdo->prepare($select);
$pdox->bindValue(':offset', $offset, PDO::PARAM_INT); 
$pdox->bindValue(':limit', $limit, PDO::PARAM_INT);   
$pdox->execute();
$fetch = $pdox->fetchAll(PDO::FETCH_ASSOC); 


echo '<br><center><table border style="text-align:center;width:600px;margin:auto;border:1px solid red" cellspacing="20">
<tr>
    <th>Name</th>
    <th>Title</th>
    <th>Roll No</th>
    <th>Delete</th>
    <th>Edit</th>
</tr>';
foreach ($fetch as $value) {
    echo '<tr>';
    echo '<td><input type="text" name="title" hidden value="' . htmlspecialchars($value['title']) . '">' . htmlspecialchars($value['title']) . '</td>';
    echo '<td><input type="text" name="para" hidden value="' . htmlspecialchars($value['para']) . '">' . htmlspecialchars($value['para']) . '</td>';
    echo '<td><span class="price">' . htmlspecialchars($value['price']) . '</span></td>';
    echo '<td><button class="delete" data-id="' . htmlspecialchars($value['id'], ENT_QUOTES) . '">DELETE</button></td>';
    echo '<td><button class="edit" data-editx="' . htmlspecialchars($value['id'], ENT_QUOTES) . '" style="cursor:pointer">EDIT</button></td>';
    echo '</tr>';
}
echo '</table></center>';

$total = $pdo->query("SELECT COUNT(*) FROM itembox")->fetchColumn();

$total_pages = ceil($total / $limit);

echo '<br></br><center><div class="pagination">';
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='?page={$i}'" . ($i == $page + 1 ? " class='active'" : "") . ">{$i}</a>";
}
echo '</div></center>';
?>
