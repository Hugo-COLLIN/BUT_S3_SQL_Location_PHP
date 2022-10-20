<?php

namespace iutnc\location\db;
class AccessData
{

    public function listVehic(string $categ, string $stDate, string $endDate) : string
    {
        $res = "";
        //return "ok";
        $pdo = ConnectionFactory::makeConnection();
        $query = <<<END
            SELECT distinct Vehicule.no_imm, Vehicule.modele FROM Vehicule, Dossier
            WHERE code_categ = ?
                AND (date_retrait < ? OR dossier.date_retour > ?)
                AND Vehicule.no_imm = Dossier.no_imm
            END;

        $st = $pdo->prepare($query);
        $st->bindValue(1, $categ);
        $st->bindValue(2, $stDate);
        $st->bindValue(3, $endDate);
        $st->execute();

        foreach ($st->fetchAll(\PDO::FETCH_ASSOC) as $row)
        {
            $res .= \PDOStatement::rowCount($st);
            for ($i = 0; $i < \PDOStatement::rowCount($st) ; $i ++)
                $res .= "i: " . $row[$i];
            $res .= "<br>";
        }
        /*
        $this.pst = this.co.prepareStatement("SELECT distinct Vehicule.no_imm, Vehicule.modele \n" +
                "FROM Vehicule, Dossier\n" +
                "WHERE code_categ = ?\n" +
                "    AND (date_retrait < ? OR dossier.date_retour > ?)\n" +
                "    AND Vehicule.no_imm = Dossier.no_imm",
                TYPE, MODE);

        this.pstSet(pst, new String[]{categ, stDate, endDate});
        return this.displayPst();
        */
        return $res;
    }

    public function pstSet(\PDOStatement $rs, array $params) : void
    {
        for ($i = 0 ; $i < sizeof($params) ; $i ++)
            $rs->bindParam($i + 1, $params[$i]);
    }

    public function testQuery ()
    {
        $res = "";
        $table = "vehicule";
        $db = ConnectionFactory::makeConnection();
        $st = $db->prepare("SELECT * FROM vehicule");
        //$st->bindParam(1, $table);
        $st->execute();

        //return $st->columnCount();
        while ($row = $st->fetch(\PDO::FETCH_NUM)) {
            for ($i = 0; $i < $st->columnCount() ; $i ++)
                $res .= "$i: $row[$i] ";
            $res .= "<br>";
        }
        return $res;
    }
}