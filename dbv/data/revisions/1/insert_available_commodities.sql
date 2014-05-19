INSERT INTO mnh_rest.available_commodities (ac_availability,ac_location,ac_quantity,ac_reason_unavailable,ac_created,comm_code,supplier_code,fac_id)  
 SELECT Availability,Location,quantityAvailable,reason4Unavailability,createdAt,CommodityID,supplierID,facilityID   
	FROM mnh_latest.cquantity_available
