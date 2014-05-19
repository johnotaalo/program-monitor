INSERT INTO mnh_rest.bemonc_functions (bem_conducted,bem_created,challenge_code,sf_code,fac_id)
 SELECT conducted,createdAt,challengeID,signalFunctionsID,facilityID
	FROM mnh_latest.bemonc_functions