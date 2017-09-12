<?php

require_once 'PDOconnection.php';

class dotaz_DB extends PDOconnection {

    public function VypisProjekty() {
        $dotaz = $this->getConnection()->prepare("SELECT * FROM project");
        $dotaz->execute();
        $projects = $dotaz->fetchAll();
        return $projects;
    }

    public function InsertProjekt($data, $id = null) {
        if (!$id) {
            $dotaz = $this->getConnection()->prepare("insert into project(nazevProjektu,DatumOdevzdaniProjektu,TypProjektu,WebovyProjekt) VALUES(?,?,?,?)");
            $result = $dotaz->execute(array($data['nazevprojektu'], $data['datumodevzdaniprojektu'], $data['typprojektu'], isset($data['webovyprojekt']) ? "1" : "0"));
        } else {
            try {
                $dotaz = $this->getConnection()->prepare("update project set NazevProjektu=?,DatumOdevzdaniProjektu=?,TypProjektu=?,WebovyProjekt=? where id=?");
                $result = $dotaz->execute(array($data['nazevprojektu'], $data['datumodevzdaniprojektu'], $data['typprojektu'], isset($data['webovyprojekt']) ? "1" : "0", $id));
            } catch (PDOException $ex) {
                echo "Error: " . $ex;
            }
        }
    }

    public function smazProjekt($idProject) {
        $dotaz = $this->getConnection()->prepare("delete from project where id=?");
        $dotaz->execute(array($idProject));
        if ($dotaz) {
            return true;
        }
        return false;
    }

    public function getProjectPodleId($idProject) {
        $dotaz = $this->getConnection()->prepare("select * from project where id=?");
        $dotaz->execute(array($idProject));
        return $dotaz->fetch();
    }

}
