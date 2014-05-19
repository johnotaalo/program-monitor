INSERT INTO mnh_rest.available_commodities (ac_availability,ac_location,ac_quantity,ac_reason_unavailable,ac_created,comm_code,supplier_code,fac_id)  
 SELECT Availability,Location,quantityAvailable,reason4Unavailability,createdAt,CommodityID,supplierID,facilityID   
	FROM mnh_latest.cquantity_available


INSERT INTO mnh_rest.available_equipments (ae_availability,ae_location,ae_fully_functional,ae_partially_functional,ae_non_functional,ae_created,eq_code,fac_id)
  SELECT equipAvailability,equipLocation,qtyFullyFunctional,qtyPartiallyFunctional,qtyNonFunctional,createdAt,equipmentID,facilityID
  FROM mnh_latest.equipments_available;

INSERT INTO mnh_rest.commodities (comm_code,comm_name,comm_unit,comm_for)
 SELECT commodityCode,commodityName,unit,commodityFor
	FROM mnh_latest.commodity;

UPDATE mnh_rest.commodities SET comm_for='ch' WHERE comm_for='mch';

INSERT INTO mnh_rest.available_resources (ar_availability,ar_location,ar_quantity,ar_reason_unavailable,ar_created,eq_code,supplier_code,fac_mfl)  
 SELECT Availability,Location,quantityAvailable,reason4Unavailability,createdAt,ResourceCode,supplierID,facilityID   
	FROM mnh_new.mnh_resource_available


INSERT INTO mnh_rest.available_resources (ar_availability,ar_location,ar_quantity,ar_reason_unavailable,ar_created,eq_code,supplier_code,fac_mfl)  
 SELECT Availability,Location,quantityAvailable,reason4Unavailability,createdAt,ResourceCode,supplierID,facilityID   
	FROM mnh_new.mch_resource_available

INSERT INTO mnh_rest.available_supplies (as_availability,as_location,as_quantity,as_reason_unavailable,as_created,supply_code,supplier_code,fac_mfl)  
 SELECT Availability,Location,quantityAvailable,reason4Unavailability,createdAt,SuppliesCode,supplierID,facilityID   
	FROM mnh_new.squantity_available

INSERT INTO mnh_rest.bemonc_functions (bem_conducted,bem_created,challenge_code,sf_code,fac_id)
 SELECT conducted,createdAt,challengeID,signalFunctionsID,facilityID
	FROM mnh_latest.bemonc_functions
INSERT INTO mnh_rest.commodity_outage_options (coo_description)
 SELECT optionDescription
	FROM mnh_latest.options_on_commodity_outage;

INSERT INTO mnh_rest.challenges (challenge_code,challenge_name)
 SELECT challengeCode,challengeName
	FROM mnh_latest.challenges

INSERT INTO mnh_rest.community_strategies (cs_response,cs_created,strat_id,fac_ID)
 SELECT strategyResponse,createdAt,strategyID,facilityID
	FROM mnh_latest.mch_community_strategy;

INSERT INTO mnh_rest.counties (county_name,county_fusion_map_id)
 SELECT countyName,countyFusionMapId
	FROM mnh_latest.county;

INSERT INTO mnh_rest.districts (district_name,district_access_code)
 SELECT districtname,districtAccessCode
	FROM mnh_latest.district;

INSERT INTO mnh_rest.equipments (eq_code,eq_name,eq_unit,eq_for)
 SELECT equipmentCode,equipmentname,equipmentunit,equipmentfor
	FROM mnh_latest.equipment;

INSERT INTO mnh_rest.facilities (fac_mfl,fac_name,fac_type,fac_level,fac_province,fac_district,fac_county,fac_ownership,fac_incharge_contact_person,fac_incharge_email,fac_incharge_telephone,fac_mch_contact_person,fac_mch_email,fac_mch_telephone,fac_maternity_contact_person,fac_maternity_email,fac_maternity_telephone,fac_created,fac_updated)
 SELECT facilitymfc,facilityname,facilitytype,facilitylevel,facilityprovince,facilitydistrict,facilitycounty,facilityownedby,facilityinchargecontactperson,facilityinchargeemail,facilityinchargetelephone,facilitymchcontactperson,facilitymchemail,facilitymchtelephone,facilitymaternitycontactperson,facilitymaternityemail,facilitymaternitytelephone,createdAt,updatedAt
	FROM mnh_latest.facility;

INSERT INTO mnh_rest.facility_owners (fo_name,fo_for,fo_created)
 SELECT facilityOwner,facilityOwnerFor,createdAt
	FROM mnh_latest.facility_owner;

INSERT INTO mnh_rest.facility_types (ft_name)
 SELECT facilitytype
	FROM mnh_latest.facility_type;

INSERT INTO mnh_rest.form_steps (fs_name)
 SELECT stepName
	FROM mnh_latest.form_steps;

INSERT INTO mnh_rest.guidelines (guide_code,guide_name,guide_for)
 SELECT guidelineCode,guidelineName,guidelineFor
	FROM mnh_latest.guidelines;

INSERT INTO mnh_rest.indicators (indicator_name,indicator_code,indicator_for)
 SELECT indicatorname,indicatorcode,indicatorfor
	FROM mnh_latest.mch_indicators;

INSERT INTO mnh_rest.log_commodity_stock_outs (lcso_usage,lcso_unavailable_times,lcso_option_on_outage,lcso_created,comm_id,fac_id)
 SELECT cUsage,cUnavailableTimes,cOptionOnOutage,createdAt,commodityID,facilityID 
	FROM mnh_latest.c_usage_stock_out_log;

INSERT INTO mnh_rest.log_indicators (li_response,li_created,indicator_code,fac_id)
 SELECT response,createdAt,indicatorID,facilityID 
	FROM mnh_latest.mch_indicator_log;

INSERT INTO mnh_rest.log_questions (lq_response,lq_response_count,question_code,fac_mfl,lq_created)
 SELECT response,noOfGuides,indicatorID,facilityID,createdAt
	FROM mnh_new.mch_questions_log;

INSERT INTO mnh_rest.log_questions (lq_response,lq_reason,lq_specified_or_follow_up,lq_created,lq_response_count,question_code,fac_mfl)
 SELECT response,reasonForResponse,specifiedOrFollowUp,createdAt,responseCount,questionID,facilityID
	FROM mnh_new.mnh_questions_log;

INSERT INTO mnh_rest.log_sessions (session_id,ip_address,user_agent,last_activity,time_accessed,user_da
ta)
 SELECT session_id,ip_address,user_agent,last_activity,time_accessed,user_data
	FROM mnh_latest.mnh_sessions_log;

INSERT INTO mnh_rest.log_supply_stock_outs (lsso_usage,lsso_unavailable_times,lsso_option_on_outage,createdAt,supply_code,fac_mfl)
 SELECT sUsage,sUnavailableTimes,sOptionOnOutage,createdAt,supplyID,facilityID
	FROM mnh_latest.s_usage_stock_out_log;

INSERT INTO mnh_rest.log_treatment (lt_other_treatment,lt_severe_dehydration_number,lt_some_dehydration_number,lt_no_dehydration_number,lt_dysentry_number,lt_no_classification_number,lt_created,treatment_code,facility_mfl)
 SELECT otherTreatment,severeDehydrationNo,someDehydrationNo,noDehydrationNo,dysentryNo,noClassificationNo,createdAt,treatmentID,facilityID
	FROM mnh_latest.mch_treatment_log;

INSERT INTO mnh_rest.ort_corner_aspects (oca_response,oca_created,question_code,fac_mfl)
 SELECT response,createdAt,questionCOde,facilityID
	FROM mnh_latest.mch_ortcorner_aspects;

INSERT INTO mnh_rest.questions (question_code,question_name,question_for)
 SELECT questionCode,mnhQuestion,mnhQuestionFor
	FROM mnh_latest.mnh_questions;

INSERT INTO mnh_rest.questions (question_code,question_name,question_for)
 SELECT questionCode,mchQuestion,mchQuestionFor
	FROM mnh_latest.mch_questions;

INSERT INTO mnh_rest.reason_no_deliveries 
 SELECT *
	FROM mnh_latest.reason_no_deliveries;

INSERT INTO mnh_rest.signal_functions 
 SELECT *
	FROM mnh_latest.signal_functions;

INSERT INTO mnh_rest.suppliers 
 SELECT *
	FROM mnh_latest.supplier;


INSERT INTO mnh_rest.supplies (supply_code,supply_name,supply_unit,supply_for)
	SELECT suppliesCode,suppliesName,suppliesUnit,suppliesFor
		FROM mnh_latest.supplies;

INSERT INTO mnh_rest.supplies_outage_options
 SELECT *
	FROM mnh_latest.options_on_supplies_outage;

INSERT INTO mnh_rest.signal_functions
 SELECT *
	FROM mnh_latest.signal_functions;

INSERT INTO mnh_rest.training_guidelines (guide_code,tg_trained_before_2010,tg_working,tg_created,fac_mfl)
 SELECT guidelineCode,lastTrained,trainedAndWorking,createdAt,facilityID
	FROM mnh_latest.guideline_training;

INSERT INTO mnh_rest.treatments (treatment_name,treatment_code,treatment_for)
 SELECT treatmentname,treatmentcode,treatmentfor
	FROM mnh_latest.mch_treatments

INSERT INTO `mnh_rest`.`survey_categories` (`sc_name`) VALUES ('baseline');
INSERT INTO `mnh_rest`.`survey_categories` (`sc_name`) VALUES ('mid-term');
INSERT INTO `mnh_rest`.`survey_categories` (`sc_name`) VALUES ('end-term');


INSERT INTO `mnh_rest`.`survey_types` (`st_name`) VALUES ('mnh');
INSERT INTO `mnh_rest`.`survey_types` (`st_name`) VALUES ('ch');


INSERT INTo mnh_rest.survey_status (ss_year,fac_id,st_id,sc_id)
SELECT
	'2013 - 2014' as ss_year,
    facilityMFC as fac_id,
    (CASE
        WHEN facilitySurveyStatus = 'complete' THEN 1
    END) as st_id,
    1 as sc_id
FROM
    mnh_new.facility
WHERE
    facilitySurveyStatus = 'complete';

INSERT INTo mnh_rest.survey_status (ss_year,fac_id,st_id,sc_id)
SELECT
	'2013 - 2014' as ss_year,
    facilityMFC as fac_id,
    (CASE
        WHEN facilityCHSurveyStatus = 'complete' THEN 2
    END) as st_id,
    1 as sc_id
FROM
    mnh_new.facility
WHERE
    facilityCHSurveyStatus = 'complete';

UPDATE guidelines SET guide_for='ch' WHERE guide_for='mch';