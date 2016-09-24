-- Variable para controlar el fin del bucle
	DECLARE fin INTEGER DEFAULT 0;
	-- Variables donde almacenar lo que nos traemos desde el SELECT
	DECLARE vc_idintento int(11);
	DECLARE vc_puntaje_total int(11);
	DECLARE vl_obtenida int(11);
	DECLARE vl_buenas int(11);
	DECLARE vl_malas int(11);
	DECLARE vl_omitida int(11);
	DECLARE vl_porcentaje_logro NUMERIC(10,1);

	-- variables nota
	DECLARE vl_nota NUMERIC(10,1);
	DECLARE vl_exigencia int(11) DEFAULT 60;

	DECLARE vl_nota_min INT(10) DEFAULT 4;
	DECLARE vl_nota_max INT(10) DEFAULT 7;
	DECLARE vl_nota_aprob NUMERIC(10,4);
	DECLARE vl_nota_reprob NUMERIC(10,4);
	DECLARE vl_nota_inicial INT(10) DEFAULT 2;
	DECLARE idconcat TEXT DEFAULT "a:";

	-- Se asigna la nota inicial en función del nivel al que pertenece la prueba.
	DECLARE vl_nivel INT(10);

	-- El SELECT que vamos a ejecutar
	DECLARE intento_cursor CURSOR FOR
	select id ,puntaje_total
	from simce_intentos_pruebas
	where idprueba = ve_idprueba;

	-- Condición de salida
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin=1;

	OPEN intento_cursor;
	get_runners: LOOP
	FETCH intento_cursor INTO vc_idintento,vc_puntaje_total;
	IF fin = 1 THEN LEAVE get_runners; END IF;

	select idnivel into vl_nivel from simce_evaluaciones where id = ve_idprueba;
	IF vl_nivel <= 10 THEN
		set vl_nota_inicial = 2;
	ELSE
		set vl_nota_inicial = 1;
	END IF;


		-- buenas
		select COUNT(*) into vl_buenas from simce_respuestas_alumno where idintento = vc_idintento AND idprueba = ve_idprueba AND estado = 1;
		-- malas
		select COUNT(*) into vl_malas from simce_respuestas_alumno where idintento = vc_idintento AND idprueba = ve_idprueba AND estado = 2;
		-- omitidas
		select COUNT(*) into vl_omitida from simce_respuestas_alumno where idintento = vc_idintento AND idprueba = ve_idprueba AND estado = 3;
		-- puntaje obtenido
		select SUM(puntaje_obtenido) into vl_obtenida from simce_respuestas_alumno where idintento = vc_idintento AND idprueba = ve_idprueba;
		-- porcentaje_logro
		set vl_porcentaje_logro = ( vl_obtenida * 100 ) / vc_puntaje_total;
		/* ------------- notas ---------------------   */
		set vl_nota_aprob = ( vl_nota_max - vl_nota_min) / ( vc_puntaje_total - ( vc_puntaje_total * ( vl_exigencia / 100 ) ) );
		set vl_nota_reprob = ( vl_nota_min - vl_nota_inicial ) / ( ( vc_puntaje_total * ( vl_exigencia / 100 ) - 0 ) );

		IF vl_nota_inicial + vl_nota_reprob * vl_obtenida <= 4 THEN
			set vl_nota = vl_nota_inicial + vl_nota_reprob * vl_obtenida;
		ELSE
			set vl_nota = ( - vl_nota_aprob * vc_puntaje_total ) + ( vl_obtenida * vl_nota_aprob ) + vl_nota_max ;
		END IF;

		/* ------------- notas ---------------------   */

		UPDATE simce_intentos_pruebas
		SET	buenas						= vl_buenas
				,malas						= vl_malas
				,omitidas					= vl_omitida
				,puntaje_obtenido	= vl_obtenida
				,porcentaje_logro	= vl_porcentaje_logro
				,nota							= vl_nota
		WHERE id = vc_idintento;

	END LOOP get_runners;
	CLOSE intento_cursor;

END