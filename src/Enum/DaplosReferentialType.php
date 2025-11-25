<?php

declare(strict_types=1);

namespace YoanBernabeu\DaplosBundle\Enum;

/**
 * Enum représentant tous les types de référentiels DAPLOS disponibles.
 *
 * Cette enum est générée automatiquement par le script bin/generate-enum.
 * Ne pas modifier manuellement - utiliser le script pour régénérer.
 *
 * @author Yoan Bernabeu
 */
enum DaplosReferentialType: string
{
    case AMENDEMENTS_DU_SOL = 'amendements_du_sol';
    case CARACTERISTIQUE_TECHNIQUE = 'caracteristique_technique';
    case CATEGORIE_D_INTERVENTION = 'categorie_d_intervention';
    case CATEGORIE_DE_CULTURE = 'categorie_de_culture';
    case CONDITIONS_METEROLOGIQUES = 'conditions_meterologiques';
    case CONDUITE_INTER_RANG = 'conduite_inter_rang';
    case DESTINATION_D_UNE_CULTURE = 'destination_d_une_culture';
    case ESPECE_BOTANIQUE_D_UNE_CULTURE = 'espece_botanique_d_une_culture';
    case EXPOSITION_DE_LA_PARCELLE = 'exposition_de_la_parcelle';
    case FAMILLE_D_INTRANT = 'famille_d_intrant';
    case INTERVENTION_AGRICOLE = 'intervention_agricole';
    case INTRANT_ET_QUALIFIANT_D_INTRANT = 'intrant_et_qualifiant_d_intrant';
    case JUSTIFICATION_DE_L_INTERVENTION = 'justification_de_l_intervention';
    case JUSTIFICATION_DE_LA_CULTURE = 'justification_de_la_culture';
    case METHODE_DE_MESURE = 'methode_de_mesure';
    case METHODE_DE_NOTATION = 'methode_de_notation';
    case MODE_DE_PRODUCTION = 'mode_de_production';
    case MOUVEMENT_PARCELLAIRE = 'mouvement_parcellaire';
    case NATURE_DU_LIEN = 'nature_du_lien';
    case OAD_DONNANT_DROIT_A_DES_CEPP = 'oad_donnant_droit_a_des_cepp';
    case ORGANISME_VIVANT_CIBLE_OU_AUXILIAIRE = 'organisme_vivant_cible_ou_auxiliaire';
    case ORIENTATION_CARDINALE_DES_RANGS = 'orientation_cardinale_des_rangs';
    case ORIENTATION_DES_RANGS_PAR_RAPPORT_A_LA_PENTE = 'orientation_des_rangs_par_rapport_a_la_pente';
    case PERIODE_DE_SEMIS_D_UNE_CULTURE = 'periode_de_semis_d_une_culture';
    case PIEGE = 'piege';
    case PROFIL_VEGETATIF = 'profil_vegetatif';
    case PROTOCOLE_DGAL = 'protocole_dgal';
    case QUALIFIANT_D_UNE_CULTURE = 'qualifiant_d_une_culture';
    case QUALIFIANT_D_UNE_MESURE = 'qualifiant_d_une_mesure';
    case REPARTITION_INTER_RANG = 'repartition_inter_rang';
    case SOUS_TYPE_DE_L_ORGANISME_VIVANT = 'sous_type_de_l_organisme_vivant';
    case STADE_DE_DEVELOPPEMENT_DE_L_ORGANISME = 'stade_de_developpement_de_l_organisme';
    case STADE_VEGETATIF = 'stade_vegetatif';
    case STATUT_D_UNE_INTERVENTION = 'statut_d_une_intervention';
    case STATUT_DU_MESSAGE = 'statut_du_message';
    case SURFACE_EXPRIMEE = 'surface_exprimee';
    case SYMPTOME_ET_DEGAT = 'symptome_et_degat';
    case TENEUR_EN_COMPOSE_CHIMIQUE = 'teneur_en_compose_chimique';
    case TERRITOIRE_REGION = 'territoire_region';
    case TRAITEMENT_DES_RESIDUS_DE_CULTURE = 'traitement_des_residus_de_culture';
    case TYPE_D_OCCUPATION_DU_SOL = 'type_d_occupation_du_sol';
    case TYPE_DE_L_ORGANISME_VIVANT_ET_OBSERVATION = 'type_de_l_organisme_vivant_et_observation';
    case TYPE_DE_MESSAGE = 'type_de_message';
    case TYPE_DE_NOTATION = 'type_de_notation';
    case TYPE_DE_PRODUIT_RECOLTE = 'type_de_produit_recolte';
    case TYPE_DE_SOL = 'type_de_sol';
    case TYPE_DE_SOUS_SOL = 'type_de_sous_sol';
    case UNITE_DE_MESURE = 'unite_de_mesure';
    case VALEUR_DE_LA_CARACTERISTIQUE_TECHNIQUE = 'valeur_de_la_caracteristique_technique';
    case VALEUR_QUALITATIVE = 'valeur_qualitative';
    case ZONE_D_OBSERVATION_TERRAIN = 'zone_d_observation_terrain';
    case ZONE_OBSERVEE_DE_LA_PLANTE = 'zone_observee_de_la_plante';
    case ZONE_RATTACHEE_A_LA_PARCELLE_CULTURALE = 'zone_rattachee_a_la_parcelle_culturale';

    /**
     * Retourne l'ID du référentiel dans l'API DAPLOS.
     */
    public function getId(): int
    {
        return match ($this) {
            self::AMENDEMENTS_DU_SOL => 633,
            self::CARACTERISTIQUE_TECHNIQUE => 635,
            self::CATEGORIE_D_INTERVENTION => 625,
            self::CATEGORIE_DE_CULTURE => 701,
            self::CONDITIONS_METEROLOGIQUES => 591,
            self::CONDUITE_INTER_RANG => 653,
            self::DESTINATION_D_UNE_CULTURE => 627,
            self::ESPECE_BOTANIQUE_D_UNE_CULTURE => 611,
            self::EXPOSITION_DE_LA_PARCELLE => 647,
            self::FAMILLE_D_INTRANT => 593,
            self::INTERVENTION_AGRICOLE => 603,
            self::INTRANT_ET_QUALIFIANT_D_INTRANT => 595,
            self::JUSTIFICATION_DE_L_INTERVENTION => 599,
            self::JUSTIFICATION_DE_LA_CULTURE => 623,
            self::METHODE_DE_MESURE => 621,
            self::METHODE_DE_NOTATION => 663,
            self::MODE_DE_PRODUCTION => 703,
            self::MOUVEMENT_PARCELLAIRE => 691,
            self::NATURE_DU_LIEN => 895,
            self::OAD_DONNANT_DROIT_A_DES_CEPP => 910,
            self::ORGANISME_VIVANT_CIBLE_OU_AUXILIAIRE => 615,
            self::ORIENTATION_CARDINALE_DES_RANGS => 649,
            self::ORIENTATION_DES_RANGS_PAR_RAPPORT_A_LA_PENTE => 651,
            self::PERIODE_DE_SEMIS_D_UNE_CULTURE => 631,
            self::PIEGE => 667,
            self::PROFIL_VEGETATIF => 657,
            self::PROTOCOLE_DGAL => 683,
            self::QUALIFIANT_D_UNE_CULTURE => 639,
            self::QUALIFIANT_D_UNE_MESURE => 671,
            self::REPARTITION_INTER_RANG => 655,
            self::SOUS_TYPE_DE_L_ORGANISME_VIVANT => 912,
            self::STADE_DE_DEVELOPPEMENT_DE_L_ORGANISME => 659,
            self::STADE_VEGETATIF => 597,
            self::STATUT_D_UNE_INTERVENTION => 601,
            self::STATUT_DU_MESSAGE => 679,
            self::SURFACE_EXPRIMEE => 641,
            self::SYMPTOME_ET_DEGAT => 669,
            self::TENEUR_EN_COMPOSE_CHIMIQUE => 613,
            self::TERRITOIRE_REGION => 681,
            self::TRAITEMENT_DES_RESIDUS_DE_CULTURE => 629,
            self::TYPE_D_OCCUPATION_DU_SOL => 685,
            self::TYPE_DE_L_ORGANISME_VIVANT_ET_OBSERVATION => 675,
            self::TYPE_DE_MESSAGE => 689,
            self::TYPE_DE_NOTATION => 665,
            self::TYPE_DE_PRODUIT_RECOLTE => 605,
            self::TYPE_DE_SOL => 643,
            self::TYPE_DE_SOUS_SOL => 645,
            self::UNITE_DE_MESURE => 637,
            self::VALEUR_DE_LA_CARACTERISTIQUE_TECHNIQUE => 589,
            self::VALEUR_QUALITATIVE => 673,
            self::ZONE_D_OBSERVATION_TERRAIN => 677,
            self::ZONE_OBSERVEE_DE_LA_PLANTE => 661,
            self::ZONE_RATTACHEE_A_LA_PARCELLE_CULTURALE => 687,
        };
    }

    /**
     * Retourne le libellé lisible du référentiel.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::AMENDEMENTS_DU_SOL => 'Amendements du sol',
            self::CARACTERISTIQUE_TECHNIQUE => 'Caractéristique technique',
            self::CATEGORIE_D_INTERVENTION => 'Catégorie d\'intervention',
            self::CATEGORIE_DE_CULTURE => 'Catégorie de culture',
            self::CONDITIONS_METEROLOGIQUES => 'Conditions métérologiques',
            self::CONDUITE_INTER_RANG => 'Conduite inter rang',
            self::DESTINATION_D_UNE_CULTURE => 'Destination d\'une culture',
            self::ESPECE_BOTANIQUE_D_UNE_CULTURE => 'Espèce botanique d’une culture',
            self::EXPOSITION_DE_LA_PARCELLE => 'Exposition de la parcelle',
            self::FAMILLE_D_INTRANT => 'Famille d\'intrant',
            self::INTERVENTION_AGRICOLE => 'Intervention agricole',
            self::INTRANT_ET_QUALIFIANT_D_INTRANT => 'Intrant et qualifiant d\'intrant',
            self::JUSTIFICATION_DE_L_INTERVENTION => 'Justification de l\'intervention',
            self::JUSTIFICATION_DE_LA_CULTURE => 'Justification de la culture',
            self::METHODE_DE_MESURE => 'Méthode de mesure',
            self::METHODE_DE_NOTATION => 'Méthode de notation',
            self::MODE_DE_PRODUCTION => 'Mode de production',
            self::MOUVEMENT_PARCELLAIRE => 'Mouvement parcellaire',
            self::NATURE_DU_LIEN => 'Nature du lien',
            self::OAD_DONNANT_DROIT_A_DES_CEPP => 'OAD donnant droit à des CEPP',
            self::ORGANISME_VIVANT_CIBLE_OU_AUXILIAIRE => 'Organisme vivant (cible ou auxiliaire)',
            self::ORIENTATION_CARDINALE_DES_RANGS => 'Orientation cardinale des rangs',
            self::ORIENTATION_DES_RANGS_PAR_RAPPORT_A_LA_PENTE => 'Orientation des rangs par rapport à la pente',
            self::PERIODE_DE_SEMIS_D_UNE_CULTURE => 'Période de semis d’une culture',
            self::PIEGE => 'Piège',
            self::PROFIL_VEGETATIF => 'Profil végétatif',
            self::PROTOCOLE_DGAL => 'Protocole DGAL',
            self::QUALIFIANT_D_UNE_CULTURE => 'Qualifiant d\'une culture',
            self::QUALIFIANT_D_UNE_MESURE => 'Qualifiant d\'une mesure',
            self::REPARTITION_INTER_RANG => 'Répartition inter rang',
            self::SOUS_TYPE_DE_L_ORGANISME_VIVANT => 'Sous-type de l\'organisme vivant',
            self::STADE_DE_DEVELOPPEMENT_DE_L_ORGANISME => 'Stade de développement de l’organisme',
            self::STADE_VEGETATIF => 'Stade végétatif',
            self::STATUT_D_UNE_INTERVENTION => 'Statut d\'une intervention',
            self::STATUT_DU_MESSAGE => 'Statut du message',
            self::SURFACE_EXPRIMEE => 'Surface exprimée',
            self::SYMPTOME_ET_DEGAT => 'Symptôme et dégât',
            self::TENEUR_EN_COMPOSE_CHIMIQUE => 'Teneur en composé chimique',
            self::TERRITOIRE_REGION => 'Territoire / Région',
            self::TRAITEMENT_DES_RESIDUS_DE_CULTURE => 'Traitement des résidus de culture',
            self::TYPE_D_OCCUPATION_DU_SOL => 'Type d\'occupation du sol',
            self::TYPE_DE_L_ORGANISME_VIVANT_ET_OBSERVATION => 'Type de l\'organisme vivant et observation',
            self::TYPE_DE_MESSAGE => 'Type de message',
            self::TYPE_DE_NOTATION => 'Type de notation',
            self::TYPE_DE_PRODUIT_RECOLTE => 'Type de produit récolté',
            self::TYPE_DE_SOL => 'Type de sol',
            self::TYPE_DE_SOUS_SOL => 'Type de sous-sol',
            self::UNITE_DE_MESURE => 'Unité de mesure',
            self::VALEUR_DE_LA_CARACTERISTIQUE_TECHNIQUE => 'Valeur de la caractéristique technique',
            self::VALEUR_QUALITATIVE => 'Valeur qualitative',
            self::ZONE_D_OBSERVATION_TERRAIN => 'Zone d’observation terrain',
            self::ZONE_OBSERVEE_DE_LA_PLANTE => 'Zone observée de la plante',
            self::ZONE_RATTACHEE_A_LA_PARCELLE_CULTURALE => 'Zone rattachée à la parcelle culturale',
        };
    }

    /**
     * Retourne le code du repository dans l'API DAPLOS.
     */
    public function getRepositoryCode(): string
    {
        return match ($this) {
            self::AMENDEMENTS_DU_SOL => 'List_SpecifiedSoilSupplement_CodeType',
            self::CARACTERISTIQUE_TECHNIQUE => 'List_TechnicalCharacteristic_CodeType',
            self::CATEGORIE_D_INTERVENTION => 'List_PlotAgriculturalProcess_CodeType',
            self::CATEGORIE_DE_CULTURE => 'List_CropCategory_CodeType',
            self::CONDITIONS_METEROLOGIQUES => 'List_AgriculturalProcessCondition_CodeType',
            self::CONDUITE_INTER_RANG => 'rep49',
            self::DESTINATION_D_UNE_CULTURE => 'List_PurposeCode_CodeType',
            self::ESPECE_BOTANIQUE_D_UNE_CULTURE => 'List_BotanicalSpecies_CodeType',
            self::EXPOSITION_DE_LA_PARCELLE => 'rep46',
            self::FAMILLE_D_INTRANT => 'List_AgriculturalProcessCropInput_CodeType',
            self::INTERVENTION_AGRICOLE => 'List_AgriculturalProcessWorkItem_CodeType',
            self::INTRANT_ET_QUALIFIANT_D_INTRANT => 'List_AgriculturalProcessCropInputSubordinateTypeCode_CodeType',
            self::JUSTIFICATION_DE_L_INTERVENTION => 'List_AgriculturalProcessReason_CodeType',
            self::JUSTIFICATION_DE_LA_CULTURE => 'List_PlantingReasonCode_CodeType',
            self::METHODE_DE_MESURE => 'List_MeasurementMethodCode_CodeType',
            self::METHODE_DE_NOTATION => 'List_NotationMethodology_CodeType',
            self::MODE_DE_PRODUCTION => 'List_ProductionType_CodeType',
            self::MOUVEMENT_PARCELLAIRE => 'List_Movement_CodeType',
            self::NATURE_DU_LIEN => 'List_linktype_CodeType',
            self::OAD_DONNANT_DROIT_A_DES_CEPP => 'List_OAD_CEPP',
            self::ORGANISME_VIVANT_CIBLE_OU_AUXILIAIRE => 'List_PestName_CodeType',
            self::ORIENTATION_CARDINALE_DES_RANGS => 'rep47',
            self::ORIENTATION_DES_RANGS_PAR_RAPPORT_A_LA_PENTE => 'rep48',
            self::PERIODE_DE_SEMIS_D_UNE_CULTURE => 'List_SowingPeriodCode_CodeType',
            self::PIEGE => 'List_TrapType_CodeType',
            self::PROFIL_VEGETATIF => 'Profils végétatifs',
            self::PROTOCOLE_DGAL => 'List_ProtocoleFormTemplate_CodeType',
            self::QUALIFIANT_D_UNE_CULTURE => 'List_SupplementaryBotanicalSpecies_CodeType',
            self::QUALIFIANT_D_UNE_MESURE => 'List_ValueExpression_CodeType',
            self::REPARTITION_INTER_RANG => 'rep50',
            self::SOUS_TYPE_DE_L_ORGANISME_VIVANT => 'List_PestSubType',
            self::STADE_DE_DEVELOPPEMENT_DE_L_ORGANISME => 'List_PestDevelopementStage_CodeType',
            self::STADE_VEGETATIF => 'List_CropStage_CodeType',
            self::STATUT_D_UNE_INTERVENTION => 'List_PlotAgriculturalProcessSubordinateTypeCode_CodeType',
            self::STATUT_DU_MESSAGE => 'List_StatusCodeType',
            self::SURFACE_EXPRIMEE => 'List_AgriculturalArea_CodeType',
            self::SYMPTOME_ET_DEGAT => 'List_SymptomDamageObserved_CodeType',
            self::TENEUR_EN_COMPOSE_CHIMIQUE => 'List_CropInputChemical_CodeType',
            self::TERRITOIRE_REGION => 'List_ReferenceType_CodeType',
            self::TRAITEMENT_DES_RESIDUS_DE_CULTURE => 'List_SoilOccupationCropResidue_CodeType',
            self::TYPE_D_OCCUPATION_DU_SOL => 'List_PlotSoilOccupation_CodeType',
            self::TYPE_DE_L_ORGANISME_VIVANT_ET_OBSERVATION => 'List_PestType_CodeType',
            self::TYPE_DE_MESSAGE => 'List_Message_CodeType',
            self::TYPE_DE_NOTATION => 'List_NotationType_CodeType',
            self::TYPE_DE_PRODUIT_RECOLTE => 'List_AgriculturalProduce_CodeType',
            self::TYPE_DE_SOL => 'List_SoilType_CodeType',
            self::TYPE_DE_SOUS_SOL => 'List_SubSoilType_CodeType',
            self::UNITE_DE_MESURE => 'List_UnitCode',
            self::VALEUR_DE_LA_CARACTERISTIQUE_TECHNIQUE => 'List_TechnicalCharacteristicSubordinateType_CodeType',
            self::VALEUR_QUALITATIVE => 'List_QualitativeValue_CodeType',
            self::ZONE_D_OBSERVATION_TERRAIN => 'List_SpecifiedLocation_CodeType',
            self::ZONE_OBSERVEE_DE_LA_PLANTE => 'List_AgroObsBasisType_CodeType',
            self::ZONE_RATTACHEE_A_LA_PARCELLE_CULTURALE => 'List_AgriculturalCountrySubdivision_CodeType',
        };
    }

    /**
     * Trouve un type de référentiel par son ID API.
     */
    public static function fromId(int $id): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->getId() === $id) {
                return $case;
            }
        }

        return null;
    }

    /**
     * Trouve un type de référentiel par son code repository.
     */
    public static function fromRepositoryCode(string $code): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->getRepositoryCode() === $code) {
                return $case;
            }
        }

        return null;
    }
}
