<?php

namespace iutnc\location\db;
class AccessData
{
    private \PDO $db;
    private \PDOStatement $st;

    public function __construct()
    {
        $this->db = ConnectionFactory::makeConnection();
    }

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

        $this->st = $this->db->prepare($query);
        $this->st->execute([$categ, $stDate, $endDate]);

        return $this->display();
    }

    public function majCal (string $plate, string $stDate, string $endDate, string $loc)
    {
        $locParam = "";
        $query = <<<END
            UPDATE Calendrier
            SET paslibre = ?
            WHERE no_imm = ?
                AND datejour BETWEEN ? AND ?
            END;

        $locParam = $loc ? "x" : null;

        $this->st = $this->db->prepare($query);
        $this->st->execute([$locParam, $plate, $stDate, $endDate]);

        return $this->plateCal($plate);
    }

    private function plateCal (string $plate) : string
    {
        $query = <<<END
            SELECT * FROM Calendrier WHERE no_imm = ?
            END;

        $this->st = $this->db->prepare($query);
        $this->st->execute([$plate]);
        return "Booking calendar for the vehicle with this plate :<br>" . $this->display();
    }

    public function locAmount (string $model, string $locDuration)
    {
        $query = <<<END
            SELECT tarif.code_tarif, tarif_jour * MOD(?,7) + tarif_hebdo * FLOOR(?/7), '€' AS Montant_location
            FROM tarif
            WHERE tarif.code_tarif = (
                SELECT categorie.code_tarif FROM Vehicule, Categorie
                WHERE vehicule.modele = ?
                    AND Vehicule.code_categ = categorie.code_categ)
            END;

        $this->st = $this->db->prepare($query);
        $this->st->execute([$locDuration, $locDuration, $model]);
        return $this->display();
    }

    public function allCategsAgencies()
    {
        $query = <<<END
            SELECT code_ag FROM Vehicule, Categorie
                WHERE categorie.code_categ = vehicule.code_categ
                GROUP BY code_ag
                HAVING count(distinct Categorie.code_categ) = (
                    SELECT count(*)
                    FROM Categorie)
            END;

        $this->st = $this->db->query($query);
        return $this->display();
    }

    public function cliList2Models()
    {
        $query = <<<END
            SELECT nom, ville, codpostal
            FROM Client, Dossier, Vehicule
            WHERE Client.code_cli = Dossier.code_cli
                AND Dossier.no_imm = Vehicule.no_imm
            GROUP BY nom, ville, codpostal, modele
            HAVING count(modele) = 2
            END;

        $this->st = $this->db->query($query);
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
        if ($res == "") $res .= "Nothing to show...";
        return $res;
    }

    private function stSet (array $params): void
    {
        for ($i = 0 ; $i < sizeof($params) ; $i ++)
            $this->st->bindValue($i + 1, $params[$i]);
    }
}