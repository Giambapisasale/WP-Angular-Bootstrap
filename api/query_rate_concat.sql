SELECT * FROM isnello.tco_preavviso_rata;

SELECT idtco_preavviso, GROUP_CONCAT(data_scadenza SEPARATOR ', ')
FROM  isnello.tco_preavviso_rata GROUP BY idtco_preavviso;

select idtco_preavviso_acqua as id,
numero_preavviso as numero_fattura,
importo_totale as importo_fattura,
DATE_FORMAT(data_elaborazione, "%d/%m/%Y") as data_fattura 
from `tco_preavviso_acqua` 
left join `tco_preavviso` on `tco_preavviso_acqua`.`idtco_preavviso` = `tco_preavviso`.`idtco_preavviso` 
left join (SELECT rata.idtco_preavviso, GROUP_CONCAT(rata.data_scadenza SEPARATOR ', ') as date_scadenza
FROM  isnello.tco_preavviso_rata rata GROUP BY rata.idtco_preavviso) rata 
on rata.idtco_preavviso = tco_preavviso.idtco_preavviso
where `tco_preavviso_acqua`.`idtacqua_dichiarazione` = 453;
