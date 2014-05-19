INSERT INTO mnh_rest.available_resources (ar_availability,ar_location,ar_quantity,ar_reason_unavailable,ar_created,eq_code,supplier_code,fac_mfl)  
 SELECT Availability,Location,quantityAvailable,reason4Unavailability,createdAt,ResourceCode,supplierID,facilityID   
	FROM mnh_new.mnh_resource_available
