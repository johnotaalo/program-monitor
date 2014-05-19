INSERT INTO mnh_rest.challenges (challenge_code,challenge_name)
 SELECT challengeCode,challengeName
	FROM mnh_latest.challenges