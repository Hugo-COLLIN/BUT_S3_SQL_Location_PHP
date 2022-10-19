<?php

namespace iutnc\location\db;
class AccessData
{

    public function listVehic(string $categ, string $stDate, string $endDate) : string
    {
        $this.pst = this.co.prepareStatement("SELECT distinct Vehicule.no_imm, Vehicule.modele \n" +
                "FROM Vehicule, Dossier\n" +
                "WHERE code_categ = ?\n" +
                "    AND (date_retrait < ? OR dossier.date_retour > ?)\n" +
                "    AND Vehicule.no_imm = Dossier.no_imm",
                TYPE, MODE);

        this.pstSet(pst, new String[]{categ, stDate, endDate});
        return this.displayPst();
    }
}