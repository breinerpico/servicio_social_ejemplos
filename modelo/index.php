<!DOCTYPE html>
<html lang="es">
<head>
        <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Servicio Social - Inicio</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #74ebd5, #ACB6E5);
      color: #333;
    }

    /* Barra de navegación */
    .navbar {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      background: #4a90e2;
      padding: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar a {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin: 5px;
      padding: 10px 15px;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      color: white;
      background: #357ABD;
      border-radius: 8px;
      transition: 0.3s;
    }

    .navbar a:hover {
      background: #2b5e8d;
    }

    .navbar img {
      width: 20px;
      height: 20px;
    }

    /* Contenido */
    .contenido {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    h1, h2 {
      text-align: center;
      color: #222;
    }

    p {
      line-height: 1.6;
      font-size: 18px;
      color: #555;
    }

    /* Espacio entre secciones */
    .seccion {
      margin-top: 60px;
    }
  </style>
</head>
<body>

  <!-- Barra superior -->
  <div class="navbar">
    <a href="#presentacion">
      <img src="img/" alt=""> presentación
    </a>
    <a href="#objetivos">
      <img src="img/" alt=""> Objetivos
    </a>
    <a href="#justificacion">
      <img src="img/" alt=""> justificacion
    </a>
    <a href="#requisitos">
      <img src="img/" alt=""> requisitos
    </a>

    <a href="inicio_sesion.php">
      <img src="img/login.png" alt="Login"> Iniciar Sesión
    </a>
  </div>

  <!-- Contenido principal -->
  <div class="contenido">
    <h1>Bienvenido a Servicio Social</h1>
    <p>
      use el menu superior en el cual se encontraran diferentes secciones donde cada una nos dara un poco de información acerca del servisio social
    </p>
<center>
    <img src="img/servicio_social.png" alt="servicio social" width="">
<center/>
    <!-- Secciones de información -->
    <div id="presentacion" class="seccion">
      <h2>Presentación</h2>
      <p>
        El servicio social estudiantil es una herramienta de trabajo practico que por ley, se usa
        para acercar a los estudiantes con la comunidad en trabajos de “Aprovechamiento del
        tiempo libre, alfabetización, iniciativas ecológicas, eventos deportivos, la promoción y
        preservación de la salud, la educación ciudadana, la organización de grupos juveniles
        y de preservación de factores socialmente relevantes, la recreación dirigida, el
        fomento de actividades físicas, practicas e intelectuales y otros que la institución
        educativa considere pertinentes para el desempeño institucional”.
      </p>
    </div>

    <div id="objetivos" class="seccion">
      <h2>Objetivos</h2>
      <h3>Objetivo general</h3>
      <p>
        Contribuir en la formación integral del estudiante Colrosarino, a través de su
        acercamiento con la realidad de su entorno, consolidar la formación académica,
        desarrollar habilidades, competencias y valores, que le faciliten la interacción con la
        sociedad, tendientes al desarrollo de valores, especialmente, la solidaridad, la
        participación, protección, conservación y mejoramiento del ambiente, la dignidad,
        sentido del trabajo y el uso del tiempo libre, buscando lograr un impacto cultural y una
        transformación socio-familiar que permita formar jóvenes autónomos, capaces de ser
        responsables y de fortalecer las relaciones interpersonales entre los miembros de la
        comunidad educativa en particular y de su grupo social en general.

    <h3>objetivo especifico</h3>
    <p>Vincular a los estudiantes de los grados décimo y undécimo en actividades de
        aprovechamiento del tiempo libre, alfabetización, ecológicas, deportivas, promoción y
        preservación de la salud, la educación para la ciudadanía, organización de grupos
        juveniles y de preservación de factores socialmente relevantes, la recreación dirigida,
        el fomento de actividades físicas, practicas e intelectuales y otros que la institución
        educativa considere pertinentes para el desempeño institucional.
        <br>
        𖣔Desarrollar en los educandos compromisos sociales con la comunidad con el fin
        de mejorar las condiciones del entorno y aumentar la responsabilidad que se debe
        adquirir frente a un trabajo de tipo social.
        <br>
        𖣔Crear espacios de proyección a la comunidad que permitan a los estudiantes el
        contacto directo con la realidad que viven las familias de su entorno.
        <br>
        𖣔Fortalecer en los estudiantes los valores institucionales como: la responsabilidad,
        respeto, compromiso, libertad, honestidad, solidaridad, justicia, pluralismo,
        convivencia y tolerancia.
        <br>
        𖣔Fomentar valores de solidaridad y compromiso en los estudiantes frente a los
        problemas y necesidades de su comunidad en relación a actividades formativas fuera
        del contexto escolar y familiar.</p>
    </div>

    <div id="justificacion" class="seccion">
      <h2>justificacion</h2>
      <p>El proyecto de Servicio Social Estudiantil es obligatorio y debe ser realizado por todo 
        estudiante para poder cumplir con lo exigido por la ley para ser proclamado bachiller,
        este debe ser un proyecto institucional, ajustado al trabajo comunitario social, el cual
        pretende formar de una manera integral a los estudiantes de la media,
        comprometiéndolos con el trabajo social y la ayuda a la comunidad educativa con
        diferentes proyectos, la formulación y ejecución del Proyecto de Servicio Social en la
        Institución Educativa Colegio Nuestra Señora del Rosario, hace parte de la propuesta
        de formación integral de los jóvenes que cursan los grados décimo y undécimo.</p>
    </div>

        <div id="requisitos" class="seccion">
      <h2>requisitos para el servicio social</h2>
      <p>Los siguientes son requisitos mínimos establecidos por la institución educativa
        Colegio Nuestra Señora del Rosario que deben cumplir los estudiantes de la media
        académica para prestar el Servicio Social Estudiantil durante el año lectivo:
        <br>
        𖣔Estar legalmente matriculado en la institución educativa y registrado en el
        Sistema de matrículas (SIMAT).
        <br>
        𖣔Estar cursando el grado 10 u 11 para poder desarrollar su Servicio Social
        Estudiantil.
        <br>
        𖣔Inscribirse en los programas de Servicio Social previamente aprobados por los
        órganos competentes ya sea dentro o fuera de ella. Para ello deberán realizar los
        trámites administrativos establecidos por la Rectoría de la Institución.</p>
    </div>
  </div>

</body>
</html>
