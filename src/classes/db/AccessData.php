<?php

namespace iutnc\location\db;
class AccessData
{
    private \PDOStatement $st;

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

    public function testQuery ()
    {

        $table = "vehicule";
        $db = ConnectionFactory::makeConnection();
        $this->st = $db->prepare("SELECT * FROM vehicule");
        //$st->bindParam(1, $table);
        $this->st->execute();

        //return $st->columnCount();
        return $this->display();
    }

    public function display(): string
    {
        $res = "";
        while ($row = $this->st->fetch(\PDO::FETCH_NUM)) {
            for ($i = 0; $i < $this->st->columnCount() ; $i ++)
                $res .= "$i: $row[$i] ";
            $res .= "<br>";
        }
        return $res;
    }

    public function stSet (array $params)
    {
        for ($i = 0 ; $i < $this->st->columnCount() ; $i ++)
            $this->st->bindValue($i + 1, $params[$i]);
    }
}