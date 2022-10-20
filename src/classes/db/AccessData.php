<?php

namespace iutnc\location\db;
class AccessData
{
    private \PDOStatement $st;

    public function listVehic_old(string $categ, string $stDate, string $endDate) : string
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

    public function listVehic(string $categ, string $stDate, string $endDate) : string
    {
        $query = <<<END
            SELECT distinct Vehicule.no_imm, Vehicule.modele FROM Vehicule, Dossier
            WHERE code_categ = ?
                AND (date_retrait < ? OR dossier.date_retour > ?)
                AND Vehicule.no_imm = Dossier.no_imm
            END;

        $db = ConnectionFactory::makeConnection();
        $this->st = $db->prepare($query);
        /*
        $this->st->bindValue(1, $categ);
        $this->st->bindValue(2, $stDate);
        $this->st->bindValue(3, $endDate);
        */
        $this->stSet([$categ, $stDate, $endDate]);
        $this->st->execute();

        //return $st->columnCount();
        return $this->display();
    }

    public function testQuery ()
    {
        $table = 'citroen';
        $v2 = 'peugeot';
        $db = ConnectionFactory::makeConnection();
        $this->st = $db->prepare("SELECT * FROM vehicule WHERE NOT marque = ? AND NOT marque = ?");

        $this->st->bindValue(1, $table);
        $this->st->bindValue(2, $v2);
        //$this->stSet(array($table, $v2));
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

    public function stSet (array $params): void
    {
        for ($i = 0 ; $i < sizeof($params) ; $i ++)
            $this->st->bindValue($i + 1, $params[$i]);
    }
}