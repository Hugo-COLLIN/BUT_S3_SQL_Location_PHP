<?php

namespace iutnc\location\db;
class AccessData
{
    private \PDOStatement $st;

    /*
     * --- QUERIES METHODS ---
     */
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
        $this->stSet([$categ, $stDate, $endDate]);
        $this->st->execute();

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

    /*
     * --- BACKGROUND METHODS ---
     */
    private function display(): string
    {
        $res = "";
        while ($row = $this->st->fetch(\PDO::FETCH_NUM)) {
            for ($i = 0; $i < $this->st->columnCount() ; $i ++)
                $res .= "$i: $row[$i] ";
            $res .= "<br>";
        }
        return $res;
    }

    private function stSet (array $params): void
    {
        for ($i = 0 ; $i < sizeof($params) ; $i ++)
            $this->st->bindValue($i + 1, $params[$i]);
    }
}