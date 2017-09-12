<?php
ob_start();
require_once '../includes/header.php';
require_once '../validator/Validator.php';
require_once '../database/Dotaz_DB.php';
if (isset($_GET['edit'])) {
    $database = new Dotaz_DB();
    $result = $database->getProjectPodleId($_GET['edit']);
    if ($result) {
        $dataForm = $result;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataForm = $_POST;
    $validator = new Validator();
    $errors = $validator->validatorFormZadaniProjektu($_POST, isset($_GET['edit']) ? $_GET['edit'] : null);
    if ($errors == 0) {
        header('Location:../index.php');
    }
}
?>
<form class="form-horizontal" id="zadaniProjektuForm" method="post" action="">
    <div class="form-group">
        <label class="control-label col-sm-2">Název projektu</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" value="<?php if (isset($dataForm['NazevProjektu'])) echo $dataForm['NazevProjektu'] ?>" name="NazevProjektu" id="nazevProjektu" ><?php if (isset($errors['NazevProjektu'])) echo $errors['NazevProjektu'] ?>
        </div>
        <?php if (isset($errors['nazevprojektu'])) echo $errors['nazevprojektu'] ?>
    </div>   
    <div class="form-group">           
        <label class="control-label col-sm-2">Datum odevzdání projektu</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" value="<?php if (isset($dataForm['DatumOdevzdaniProjektu'])) echo $dataForm['DatumOdevzdaniProjektu'] ?>" name="DatumOdevzdaniProjektu" id="DatumOdevzdaniProjektu">
        </div>
        <?php if (isset($errors['datumodevzdaniprojektu'])) echo $errors['datumodevzdaniprojektu'] ?>
    </div>
    <div class="form-group">       
        <label class="control-label col-sm-2">Typ projektu</label>
        <div class="col-sm-7">
            <select id="TypProjektu" name="TypProjektu" style="width: 150px;">
                <option value="">Vyberte typ projektu</option>
                <option value="Časově omezený projekt" <?php if (isset($dataForm['TypProjektu'])) {
            if ($dataForm['TypProjektu'] == 'Časově omezený projekt') echo 'selected';
        } ?>>Časově omezený projekt</option>
                <option value="Continous integration" <?php if (isset($dataForm['TypProjektu'])) {
            if ($dataForm['TypProjektu'] == 'Continous integration') echo 'selected';
        } ?>>Continous integration</option>
            </select>
<?php if (isset($errors['typprojektu'])) echo $errors['typprojektu'] ?>
        </div>

    </div>    
    <div class="form-group">     
        <label class="control-label col-sm-2">Webový projekt</label>
        <div class="col-sm-1">
            <input type="checkbox" id="WebovyProjekt" name="WebovyProjekt" value="1" <?php echo isset($dataForm['WebovyProjekt']) ? "checked='1'" : ""; ?> class="form-control">  
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2">
            <button type="submit" class="form-control btn-info">Vlož projekt</button>   
        </div>  
    </div>    
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('#zadaniProjektuForm').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                NazevProjektu: {
                    validators: {
                        notEmpty: {
                            message: 'Prosím vyplňte název projektu'
                        }
                    }
                },
                DatumOdevzdaniProjektu: {
                    validators: {
                        regexp: {
                            regexp: '(0?[1-9]|[12][0-9]|3[01]).(0?[1-9]|1[012]).((19|20)\\d\\d)',
                            message: 'Toto není správný formát - formát musí být ve tvaru D.M.Y'
                        },
                        notEmpty: {
                            message: 'Prosím zadejte datum odevzdání projektu'
                        }
                    }
                },
                TypProjektu: {
                    validators: {
                        notEmpty: {
                            message: 'Prosím vyberte typ projektu'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            // Prevent submit form
            e.preventDefault();
            var existID =<?php echo json_encode((isset($_GET['edit'])) ? $_GET['edit'] : ""); ?>;
            if (existID) {
                alert("Váš projekt byl úspěšně editován");
            } else {
                alert("Váš projekt byl vložen do databáze");
            }
            $('#zadaniProjektuForm').bootstrapValidator('defaultSubmit');
        });

    });

</script>
<?php
require_once '../includes//footer.php';
ob_flush();
?>