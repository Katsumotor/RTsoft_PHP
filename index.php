<?php
ob_start();
require_once './includes/header.php';
require_once 'database/Dotaz_DB.php';
$database = new Dotaz_DB();
if (isset($_GET['smazat'])) {
    $result = $database->smazProjekt($_GET['smazat']);
    if ($result) {
        echo "<h2>Požadovaný projekt byl úspěšně smazán</h2>";
    } else {
        echo "<h2>Nebyl nalezen požadovaný projekt</h2>";
    }
} elseif (isset($_GET['edit'])) {
    $database->getProjectPodleId($_GET['edit']);
}
?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Project ID</th>
            <th>Název projektu</th>
            <th>Datum odevzdání projektu</th>
            <th>Typ projektu</th>
            <th>Webový projekt</th>
            <th>Editovat project</th>
            <th>Smazat project</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($database->VypisProjekty() as $project) {
            ?>
            <tr>
                <td><?php echo $project['id'] ?></td>
                <td><?php echo $project['NazevProjektu'] ?></td>
                <td><?php echo $project['DatumOdevzdaniProjektu'] ?></td>
                <td><?php echo $project['TypProjektu'] ?></td>
                <td><?php echo $project['WebovyProjekt'] == 1 ? "ano" : "ne" ?></td>
                <td><a class="btn btn-info" href="form/FormZadaniProjektu.php?edit=<?php echo $project['id'] ?>">Editovat</td> 
                <td><a class="btn btn-danger" href="?smazat=<?php echo $project['id'] ?>">Smazat</td>  
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require_once './includes/footer.php';
ob_end_flush();
?>
