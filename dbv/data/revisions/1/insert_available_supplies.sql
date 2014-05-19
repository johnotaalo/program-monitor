INSERT INTO mnh_rest.available_supplies (as_availability,as_location,as_quantity,as_reason_unavailable,as_created,supply_code,supplier_code,fac_mfl)  
 SELECT Availability,Location,quantityAvailable,reason4Unavailability,createdAt,SuppliesCode,supplierID,facilityID   
	FROM mnh_new.squantity_available