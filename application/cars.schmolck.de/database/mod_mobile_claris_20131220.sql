-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Dez 2013 um 16:52
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `pascal_cars.schmolck.de`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_mobile_claris_20131220`
--

CREATE TABLE IF NOT EXISTS `mod_mobile_claris_20131220` (
  `0_laenge1` int(11) NOT NULL,
  `A_satz_nummer` int(11) NOT NULL,
  `B_interne_nummer` text COLLATE utf8_bin NOT NULL,
  `C_kategorie` text COLLATE utf8_bin NOT NULL,
  `D_marke` text COLLATE utf8_bin NOT NULL,
  `E_modell` text COLLATE utf8_bin NOT NULL,
  `F_leistung` int(11) NOT NULL,
  `G_hu` text COLLATE utf8_bin NOT NULL,
  `H_au` text COLLATE utf8_bin NOT NULL,
  `I_ez` text COLLATE utf8_bin NOT NULL,
  `J_kilometer` int(11) NOT NULL,
  `K_preis` int(11) NOT NULL,
  `L_mwst` int(11) NOT NULL,
  `M_leer` int(11) NOT NULL,
  `N_oldtimer` int(11) NOT NULL,
  `O_vin` text COLLATE utf8_bin NOT NULL,
  `P_beschaedigt` int(11) NOT NULL,
  `Q_farbe` text COLLATE utf8_bin NOT NULL,
  `R_klima` int(11) NOT NULL,
  `S_taxi` int(11) NOT NULL,
  `T_behindertengerecht` int(11) NOT NULL,
  `U_jahreswagen` int(11) NOT NULL,
  `V_neufahrzeug` int(11) NOT NULL,
  `W_empfehlung` int(11) NOT NULL,
  `X_haendlerpreis` int(11) NOT NULL,
  `Y_leer` int(11) NOT NULL,
  `Z_bemerkung` text COLLATE utf8_bin NOT NULL,
  `AA_bild_id` text COLLATE utf8_bin NOT NULL,
  `AB_metallic` int(11) NOT NULL,
  `AC_waehrung` text COLLATE utf8_bin NOT NULL,
  `AD_mwstsatz` float NOT NULL,
  `AE_garantie` int(11) NOT NULL,
  `AF_leichtmetallfelgen` int(11) NOT NULL,
  `AG_esp` int(11) NOT NULL,
  `AH_abs` int(11) NOT NULL,
  `AI_anhaengerkupplung` int(11) NOT NULL,
  `AJ_lederausstattung` int(11) NOT NULL,
  `AK_wegfahrsperre` int(11) NOT NULL,
  `AL_navigationssystem` int(11) NOT NULL,
  `AM_schiebedach` int(11) NOT NULL,
  `AN_zentralverriegelung` int(11) NOT NULL,
  `AO_fensterheber` int(11) NOT NULL,
  `AP_allradantrieb` int(11) NOT NULL,
  `AQ_tueren` int(11) NOT NULL,
  `AR_umweltplakette` int(11) NOT NULL,
  `AS_servolenkung` int(11) NOT NULL,
  `AT_biodiesel` int(11) NOT NULL,
  `AU_scheckheftgepflegt` int(11) NOT NULL,
  `AV_katalysator` int(11) NOT NULL,
  `AW_kickstarter` int(11) NOT NULL,
  `AX_estarter` int(11) NOT NULL,
  `AY_vorfuehrfahrzeug` int(11) NOT NULL,
  `AZ_antrieb` int(11) NOT NULL,
  `BA_ccm` int(11) NOT NULL,
  `BB_tragkraft` int(11) NOT NULL,
  `BC_nutzlast` int(11) NOT NULL,
  `BD_gesamtgewicht` int(11) NOT NULL,
  `BE_hubhoehe` int(11) NOT NULL,
  `BF_bauhoehe` int(11) NOT NULL,
  `BG_baujahr` int(11) NOT NULL,
  `BH_betriebsstunden` int(11) NOT NULL,
  `BI_sitze` int(11) NOT NULL,
  `BJ_schadstoff` int(11) NOT NULL,
  `BK_kabinenart` int(11) NOT NULL,
  `BL_achsen` int(11) NOT NULL,
  `BM_tempomat` int(11) NOT NULL,
  `BN_standheizung` int(11) NOT NULL,
  `BO_kabine` int(11) NOT NULL,
  `BP_schutzdach` int(11) NOT NULL,
  `BQ_vollverkleidung` int(11) NOT NULL,
  `BR_kommunal` int(11) NOT NULL,
  `BS_kran` int(11) NOT NULL,
  `BT_retarder_intarder` int(11) NOT NULL,
  `BU_schlafplatz` int(11) NOT NULL,
  `BV_tv` int(11) NOT NULL,
  `BW_wc` int(11) NOT NULL,
  `BX_ladebordwand` int(11) NOT NULL,
  `BY_hydraulikanlage` int(11) NOT NULL,
  `BZ_schiebetuer` int(11) NOT NULL,
  `CA_radformel` int(11) NOT NULL,
  `CB_trennwand` int(11) NOT NULL,
  `CC_ebs` int(11) NOT NULL,
  `CD_vermietbar` int(11) NOT NULL,
  `CE_kompressor` int(11) NOT NULL,
  `CF_luftfederung` int(11) NOT NULL,
  `CG_scheibenbremse` int(11) NOT NULL,
  `CH_fronthydraulik` int(11) NOT NULL,
  `CI_bss` int(11) NOT NULL,
  `CJ_schnellwechsel` int(11) NOT NULL,
  `CK_zsa` int(11) NOT NULL,
  `CL_kueche` int(11) NOT NULL,
  `CM_kuehlbox` int(11) NOT NULL,
  `CN_schlafsitze` int(11) NOT NULL,
  `CO_frontheber` int(11) NOT NULL,
  `CP_sichtbar_nur_fuer_haendler` int(11) NOT NULL,
  `CQ_reserviert` int(11) NOT NULL,
  `CR_envkv` int(11) NOT NULL,
  `CS_verbrauch_innerorts` int(11) NOT NULL,
  `CT_verbrauch_ausserorts` int(11) NOT NULL,
  `CU_verbrauch_kombiniert` int(11) NOT NULL,
  `CV_emission` int(11) NOT NULL,
  `CW_xenonscheinwerfer` int(11) NOT NULL,
  `CX_sitzheizung` int(11) NOT NULL,
  `CY_partikelfilter` int(11) NOT NULL,
  `CZ_einparkhilfe` int(11) NOT NULL,
  `DA_schwackecode` int(11) NOT NULL,
  `DB_lieferdatum` int(11) NOT NULL,
  `DC_lieferfrist` int(11) NOT NULL,
  `DD_ueberfuehrungskosten` int(11) NOT NULL,
  `DE_hu_au_neu` int(11) NOT NULL,
  `DF_kraftstoffart` int(11) NOT NULL,
  `DG_getriebeart` int(11) NOT NULL,
  `DH_exportfahrzeug` int(11) NOT NULL,
  `DI_tageszulassung` int(11) NOT NULL,
  `DJ_blickfaenger` int(11) NOT NULL,
  `DK_hsn` int(11) NOT NULL,
  `DL_tsn` text COLLATE utf8_bin NOT NULL,
  `DM_seite_1_inserat` int(11) NOT NULL,
  `DN_leer` text COLLATE utf8_bin NOT NULL,
  `DO_leer` text COLLATE utf8_bin NOT NULL,
  `DP_e10` int(11) NOT NULL,
  `DQ_qualitaetssiegel` int(11) NOT NULL,
  `DR_pflanzenoel` int(11) NOT NULL,
  `DS_scr` int(11) NOT NULL,
  `DT_koffer` int(11) NOT NULL,
  `DU_sturzbuegel` int(11) NOT NULL,
  `DV_scheibe` int(11) NOT NULL,
  `DW_standklima` int(11) NOT NULL,
  `DX_ssbereifung` int(11) NOT NULL,
  `DY_strassenzulassung` int(11) NOT NULL,
  `DZ_etagenbett` int(11) NOT NULL,
  `EA_festbett` int(11) NOT NULL,
  `EB_heckgarage` int(11) NOT NULL,
  `EC_markise` int(11) NOT NULL,
  `ED_sepdusche` int(11) NOT NULL,
  `EE_solaranlage` int(11) NOT NULL,
  `EF_mittelsitzgruppe` int(11) NOT NULL,
  `EG_rundsitzgruppe` int(11) NOT NULL,
  `EH_seitensitzgruppe` int(11) NOT NULL,
  `EL_hagelschaden` int(11) NOT NULL,
  `EJ_schlafplaetze` int(11) NOT NULL,
  `EK_fahrzeuglaenge` int(11) NOT NULL,
  `EL_fahrzeugbreite` int(11) NOT NULL,
  `EM_fahrzeughoehe` int(11) NOT NULL,
  `EN_laderaum_europalette` int(11) NOT NULL,
  `EO_laderaum_volumen` int(11) NOT NULL,
  `EP_laderaum_laenge` int(11) NOT NULL,
  `ER_laderaum_hoehe` int(11) NOT NULL,
  `ES_anzeige_erneuern` int(11) NOT NULL,
  `ET_effektiver_jahreszins` int(11) NOT NULL,
  `EU_monatliche_rate` int(11) NOT NULL,
  `EV_laufzeit` int(11) NOT NULL,
  `EW_anzahlung` int(11) NOT NULL,
  `EX_schlussrate` int(11) NOT NULL,
  `EY_finanzierungsfeature` int(11) NOT NULL,
  `EZ_interieurfarbe` int(11) NOT NULL,
  `FA_interieurtyp` int(11) NOT NULL,
  `FB_airbag` int(11) NOT NULL,
  `FC_vorbesitzer` int(11) NOT NULL,
  `FD_topinserat` int(11) NOT NULL,
  `FE_bruttokreditbetrag` int(11) NOT NULL,
  `FF_abschlussgebuehren` int(11) NOT NULL,
  `FG_ratenabsicherung` int(11) NOT NULL,
  `FH_nettokreditbetrag` int(11) NOT NULL,
  `FI_anbieterbank` text COLLATE utf8_bin NOT NULL,
  `FJ_sollzinsatz` int(11) NOT NULL,
  `FK_art_sollzinssatz` int(11) NOT NULL,
  `FL_landesversion` int(11) NOT NULL,
  `FM_video_url` int(11) NOT NULL,
  `FN_energieeffizienzklasse` int(11) NOT NULL,
  `FO_envkv_benzin_sorte` int(11) NOT NULL,
  `FP_elektrische_seitenspiegel` int(11) NOT NULL,
  `FQ_sportfahrwerk` int(11) NOT NULL,
  `FR_sportpaket` int(11) NOT NULL,
  `FS_bluetooth` int(11) NOT NULL,
  `FT_bordcomputer` int(11) NOT NULL,
  `FU_cdspieler` int(11) NOT NULL,
  `FV_elektrische_sitzverstellung` int(11) NOT NULL,
  `FW_headup` int(11) NOT NULL,
  `FX_freisprech` int(11) NOT NULL,
  `FY_mp3` int(11) NOT NULL,
  `FZ_multifunktionslenkrad` int(11) NOT NULL,
  `GA_skisack` int(11) NOT NULL,
  `GB_tuner` int(11) NOT NULL,
  `GC_sportsitze` int(11) NOT NULL,
  `GD_panorama` int(11) NOT NULL,
  `GE_kindersitzbefestigung` int(11) NOT NULL,
  `GF_kurvenlicht` int(11) NOT NULL,
  `GG_lichtsensor` int(11) NOT NULL,
  `GH_nebelscheinwerfer` int(11) NOT NULL,
  `GI_tagfahrlicht` int(11) NOT NULL,
  `GJ_traktionskontrolle` int(11) NOT NULL,
  `GK_start_stop` int(11) NOT NULL,
  `GL_regensensor` int(11) NOT NULL,
  `GM_nichtraucher` int(11) NOT NULL,
  `GN_dachreling` int(11) NOT NULL,
  `GO_unfallfahrzeug` int(11) NOT NULL,
  `GP_fahrbereit` int(11) NOT NULL,
  `GQ_produktionsdatum` date NOT NULL,
  `GR_einparkhilfen_vorne` int(11) NOT NULL,
  `GS_einparkhilfen_hinten` int(11) NOT NULL,
  `GT_einparkhilfe_kamera` int(11) NOT NULL,
  `GU_einparkhilfe_selbstlenkend` int(11) NOT NULL,
  PRIMARY KEY (`A_satz_nummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Claris Fahrzeug Datenbank vom 20.12.2013';
