<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsCommunesVenuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertRegions();
        $this->insertCommunes();
        $this->insertVenues();
    }

    public function insertRegions(): void
    {
        $now = now();
        $regions = [
            ['AP', 'REGIÓN DE ARICA Y PARINACOTA', 'XV',1],
            ['TA', 'REGIÓN DE TARAPACÁ', 'I',2],
            ['AN', 'REGIÓN DE ANTOFAGASTA', 'II',3],
            ['AT', 'REGIÓN DE ATACAMA', 'III',4],
            ['CO', 'REGIÓN DE COQUIMBO', 'IV',5],
            ['VA', 'REGIÓN DE VALPARAÍSO', 'V',6],
            ['RM', 'REGIÓN METROPOLITANA DE SANTIAGO', 'RM',7],
            ['OH', 'REGIÓN DEL LIBERTADOR GRAL. BERNARDO O\'HIGGINS', 'VI',8],
            ['MA', 'REGIÓN DEL MAULE', 'VII',9],
            ['NB', 'REGIÓN DE ÑUBLE', 'XVI',10],
            ['BI', 'REGIÓN DEL BIOBÍO', 'VIII',11],
            ['LA', 'REGIÓN DE LA ARAUCANÍA', 'IX',12],
            ['LR', 'REGIÓN DE LOS RÍOS', 'XIV',13],
            ['LL', 'REGIÓN DE LOS LAGOS', 'X',14],
            ['AI', 'REGIÓN DE  AYSÉN DEL GRAL. CARLOS IBÁÑEZ DEL CAMPO', 'XI',15],
            ['MG', 'REGIÓN DE MAGALLANES Y DE LA ANTÁRTICA CHILENA', 'XII',16],
            ['DF', 'DEFAULT', 'DF',17]
        ];
        $regions = array_map(function ($region) use ($now){
           return [
               'abr_region' => $region[0],
               'gloss_region' => $region[1],
               'code_varchar' => $region[2],
               'physical_order' => $region[3],
               'created_at' => $now,
               'updated_at' => $now,
           ];
        }, $regions);

        DB::table('regions')->insert($regions);
    }

    public function insertCommunes(): void
    {
        $now = now();
        $communes = [
            ['01101','IQUIQUE',2],
            ['01107','ALTO HOSPICIO',2],
            ['01401','POZO ALMONTE',2],
            ['01402','CAMIÑA',2],
            ['01403','COLCHANE',2],
            ['01404','HUARA',2],
            ['01405','PICA',2],
            ['02101','ANTOFAGASTA',3],
            ['02102','MEJILLONES',3],
            ['02103','SIERRA GORDA',3],
            ['02104','TALTAL',3],
            ['02201','CALAMA',3],
            ['02202','OLLAGÜE',3],
            ['02203','SAN PEDRO DE ATACAMA',3],
            ['02301','TOCOPILLA',3],
            ['02302','MARÍA ELENA',3],
            ['03101','COPIAPÓ',4],
            ['03102','CALDERA',4],
            ['03103','TIERRA AMARILLA',4],
            ['03201','CHAÑARAL',4],
            ['03202','DIEGO DE ALMAGRO',4],
            ['03301','VALLENAR',4],
            ['03302','ALTO DEL CARMEN',4],
            ['03303','FREIRINA',4],
            ['03304','HUASCO',4],
            ['04101','LA SERENA',5],
            ['04102','COQUIMBO',5],
            ['04103','ANDACOLLO',5],
            ['04104','LA HIGUERA',5],
            ['04105','PAIGUANO',5],
            ['04106','VICUÑA',5],
            ['04201','ILLAPEL',5],
            ['04202','CANELA',5],
            ['04203','LOS VILOS',5],
            ['04204','SALAMANCA',5],
            ['04301','OVALLE',5],
            ['04302','COMBARBALÁ',5],
            ['04303','MONTE PATRIA',5],
            ['04304','PUNITAQUI',5],
            ['04305','RÍO HURTADO',5],
            ['05101','VALPARAÍSO',6],
            ['05102','CASABLANCA',6],
            ['05103','CONCÓN',6],
            ['05104','JUAN FERNÁNDEZ',6],
            ['05105','PUCHUNCAVÍ',6],
            ['05107','QUINTERO',6],
            ['05109','VIÑA DEL MAR',6],
            ['05201','ISLA DE PASCUA',6],
            ['05301','LOS ANDES',6],
            ['05302','CALLE LARGA',6],
            ['05303','RINCONADA',6],
            ['05304','SAN ESTEBAN',6],
            ['05401','LA LIGUA',6],
            ['05402','CABILDO',6],
            ['05403','PAPUDO',6],
            ['05404','PETORCA',6],
            ['05405','ZAPALLAR',6],
            ['05501','QUILLOTA',6],
            ['05502','CALERA',6],
            ['05503','HIJUELAS',6],
            ['05504','LA CRUZ',6],
            ['05506','NOGALES',6],
            ['05601','SAN ANTONIO',6],
            ['05602','ALGARROBO',6],
            ['05603','CARTAGENA',6],
            ['05604','EL QUISCO',6],
            ['05605','EL TABO',6],
            ['05606','SANTO DOMINGO',6],
            ['05701','SAN FELIPE',6],
            ['05702','CATEMU',6],
            ['05703','LLAILLAY',6],
            ['05704','PANQUEHUE',6],
            ['05705','PUTAENDO',6],
            ['05706','SANTA MARÍA',6],
            ['05801','QUILPUÉ',6],
            ['05802','LIMACHE',6],
            ['05803','OLMUÉ',6],
            ['05804','VILLA ALEMANA',6],
            ['06101','RANCAGUA',8],
            ['06102','CODEGUA',8],
            ['06103','COINCO',8],
            ['06104','COLTAUCO',8],
            ['06105','DOÑIHUE',8],
            ['06106','GRANEROS',8],
            ['06107','LAS CABRAS',8],
            ['06108','MACHALÍ',8],
            ['06109','MALLOA',8],
            ['06110','MOSTAZAL',8],
            ['06111','OLIVAR',8],
            ['06112','PEUMO',8],
            ['06113','PICHIDEGUA',8],
            ['06114','QUINTA DE TILCOCO',8],
            ['06115','RENGO',8],
            ['06116','REQUÍNOA',8],
            ['06117','SAN VICENTE',8],
            ['06201','PICHILEMU',8],
            ['06202','LA ESTRELLA',8],
            ['06203','LITUECHE',8],
            ['06204','MARCHIHUE',8],
            ['06205','NAVIDAD',8],
            ['06206','PAREDONES',8],
            ['06301','SAN FERNANDO',8],
            ['06302','CHÉPICA',8],
            ['06303','CHIMBARONGO',8],
            ['06304','LOLOL',8],
            ['06305','NANCAGUA',8],
            ['06306','PALMILLA',8],
            ['06307','PERALILLO',8],
            ['06308','PLACILLA',8],
            ['06309','PUMANQUE',8],
            ['06310','SANTA CRUZ',8],
            ['07101','TALCA',9],
            ['07102','CONSTITUCIÓN',9],
            ['07103','CUREPTO',9],
            ['07104','EMPEDRADO',9],
            ['07105','MAULE',9],
            ['07106','PELARCO',9],
            ['07107','PENCAHUE',9],
            ['07108','RÍO CLARO',9],
            ['07109','SAN CLEMENTE',9],
            ['07110','SAN RAFAEL',9],
            ['07201','CAUQUENES',9],
            ['07202','CHANCO',9],
            ['07203','PELLUHUE',9],
            ['07301','CURICÓ',9],
            ['07302','HUALAÑÉ',9],
            ['07303','LICANTÉN',9],
            ['07304','MOLINA',9],
            ['07305','RAUCO',9],
            ['07306','ROMERAL',9],
            ['07307','SAGRADA FAMILIA',9],
            ['07308','TENO',9],
            ['07309','VICHUQUÉN',9],
            ['07401','LINARES',9],
            ['07402','COLBÚN',9],
            ['07403','LONGAVÍ',9],
            ['07404','PARRAL',9],
            ['07405','RETIRO',9],
            ['07406','SAN JAVIER',9],
            ['07407','VILLA ALEGRE',9],
            ['07408','YERBAS BUENAS',9],
            ['08101','CONCEPCIÓN',11],
            ['08102','CORONEL',11],
            ['08103','CHIGUAYANTE',11],
            ['08104','FLORIDA',11],
            ['08105','HUALQUI',11],
            ['08106','LOTA',11],
            ['08107','PENCO',11],
            ['08108','SAN PEDRO DE LA PAZ',11],
            ['08109','SANTA JUANA',11],
            ['08110','TALCAHUANO',11],
            ['08111','TOMÉ',11],
            ['08112','HUALPÉN',11],
            ['08201','LEBU',11],
            ['08202','ARAUCO',11],
            ['08203','CAÑETE',11],
            ['08204','CONTULMO',11],
            ['08205','CURANILAHUE',11],
            ['08206','LOS ÁLAMOS',11],
            ['08207','TIRÚA',11],
            ['08301','LOS ÁNGELES',11],
            ['08302','ANTUCO',11],
            ['08303','CABRERO',11],
            ['08304','LAJA',11],
            ['08305','MULCHÉN',11],
            ['08306','NACIMIENTO',11],
            ['08307','NEGRETE',11],
            ['08308','QUILACO',11],
            ['08309','QUILLECO',11],
            ['08310','SAN ROSENDO',11],
            ['08311','SANTA BÁRBARA',11],
            ['08312','TUCAPEL',11],
            ['08313','YUMBEL',11],
            ['08314','ALTO BIOBÍO',11],
            ['09101','TEMUCO',12],
            ['09102','CARAHUE',12],
            ['09103','CUNCO',12],
            ['09104','CURARREHUE',12],
            ['09105','FREIRE',12],
            ['09106','GALVARINO',12],
            ['09107','GORBEA',12],
            ['09108','LAUTARO',12],
            ['09109','LONCOCHE',12],
            ['09110','MELIPEUCO',12],
            ['09111','NUEVA IMPERIAL',12],
            ['09112','PADRE LAS CASAS',12],
            ['09113','PERQUENCO',12],
            ['09114','PITRUFQUÉN',12],
            ['09115','PUCÓN',12],
            ['09116','SAAVEDRA',12],
            ['09117','TEODORO SCHMIDT',12],
            ['09118','TOLTÉN',12],
            ['09119','VILCÚN',12],
            ['09120','VILLARRICA',12],
            ['09121','CHOLCHOL',12],
            ['09201','ANGOL',12],
            ['09202','COLLIPULLI',12],
            ['09203','CURACAUTÍN',12],
            ['09204','ERCILLA',12],
            ['09205','LONQUIMAY',12],
            ['09206','LOS SAUCES',12],
            ['09207','LUMACO',12],
            ['09208','PURÉN',12],
            ['09209','RENAICO',12],
            ['09210','TRAIGUÉN',12],
            ['09211','VICTORIA',12],
            ['10101','PUERTO MONTT',14],
            ['10102','CALBUCO',14],
            ['10103','COCHAMÓ',14],
            ['10104','FRESIA',14],
            ['10105','FRUTILLAR',14],
            ['10106','LOS MUERMOS',14],
            ['10107','LLANQUIHUE',14],
            ['10108','MAULLÍN',14],
            ['10109','PUERTO VARAS',14],
            ['10201','CASTRO',14],
            ['10202','ANCUD',14],
            ['10203','CHONCHI',14],
            ['10204','CURACO DE VÉLEZ',14],
            ['10205','DALCAHUE',14],
            ['10206','PUQUELDÓN',14],
            ['10207','QUEILÉN',14],
            ['10208','QUELLÓN',14],
            ['10209','QUEMCHI',14],
            ['10210','QUINCHAO',14],
            ['10301','OSORNO',14],
            ['10302','PUERTO OCTAY',14],
            ['10303','PURRANQUE',14],
            ['10304','PUYEHUE',14],
            ['10305','RÍO NEGRO',14],
            ['10306','SAN JUAN DE LA COSTA',14],
            ['10307','SAN PABLO',14],
            ['10401','CHAITÉN',14],
            ['10402','FUTALEUFÚ',14],
            ['10403','HUALAIHUÉ',14],
            ['10404','PALENA',14],
            ['11101','COYHAIQUE',15],
            ['11102','LAGO VERDE',15],
            ['11201','AYSÉN',15],
            ['11202','CISNES',15],
            ['11203','GUAITECAS',15],
            ['11301','COCHRANE',15],
            ['11302','O’HIGGINS',15],
            ['11303','TORTEL',15],
            ['11401','CHILE CHICO',15],
            ['11402','RÍO IBÁÑEZ',15],
            ['12101','PUNTA ARENAS',16],
            ['12102','LAGUNA BLANCA',16],
            ['12103','RÍO VERDE',16],
            ['12104','SAN GREGORIO',16],
            ['12201','CABO DE HORNOS (EX - NAVARINO)',16],
            ['12202','ANTÁRTICA',16],
            ['12301','PORVENIR',16],
            ['12302','PRIMAVERA',16],
            ['12303','TIMAUKEL',16],
            ['12401','NATALES',16],
            ['12402','TORRES DEL PAINE',16],
            ['13101','SANTIAGO',7],
            ['13102','CERRILLOS',7],
            ['13103','CERRO NAVIA',7],
            ['13104','CONCHALÍ',7],
            ['13105','EL BOSQUE',7],
            ['13106','ESTACIÓN CENTRAL',7],
            ['13107','HUECHURABA',7],
            ['13108','INDEPENDENCIA',7],
            ['13109','LA CISTERNA',7],
            ['13110','LA FLORIDA',7],
            ['13111','LA GRANJA',7],
            ['13112','LA PINTANA',7],
            ['13113','LA REINA',7],
            ['13114','LAS CONDES',7],
            ['13115','LO BARNECHEA',7],
            ['13116','LO ESPEJO',7],
            ['13117','LO PRADO',7],
            ['13118','MACUL',7],
            ['13119','MAIPÚ',7],
            ['13120','ÑUÑOA',7],
            ['13121','PEDRO AGUIRRE CERDA',7],
            ['13122','PEÑALOLÉN',7],
            ['13123','PROVIDENCIA',7],
            ['13124','PUDAHUEL',7],
            ['13125','QUILICURA',7],
            ['13126','QUINTA NORMAL',7],
            ['13127','RECOLETA',7],
            ['13128','RENCA',7],
            ['13129','SAN JOAQUÍN',7],
            ['13130','SAN MIGUEL',7],
            ['13131','SAN RAMÓN',7],
            ['13132','VITACURA',7],
            ['13201','PUENTE ALTO',7],
            ['13202','PIRQUE',7],
            ['13203','SAN JOSÉ DE MAIPO',7],
            ['13301','COLINA',7],
            ['13302','LAMPA ',7],
            ['13303','TILTIL',7],
            ['13401','SAN BERNARDO',7],
            ['13402','BUIN',7],
            ['13403','CALERA DE TANGO',7],
            ['13404','PAINE',7],
            ['13501','MELIPILLA',7],
            ['13502','ALHUÉ',7],
            ['13503','CURACAVÍ',7],
            ['13504','MARÍA PINTO',7],
            ['13505','SAN PEDRO',7],
            ['13601','TALAGANTE',7],
            ['13602','EL MONTE',7],
            ['13603','ISLA DE MAIPO',7],
            ['13604','PADRE HURTADO',7],
            ['13605','PEÑAFLOR',7],
            ['14101','VALDIVIA',13],
            ['14102','CORRAL',13],
            ['14103','LANCO',13],
            ['14104','LOS LAGOS',13],
            ['14105','MÁFIL',13],
            ['14106','MARIQUINA',13],
            ['14107','PAILLACO',13],
            ['14108','PANGUIPULLI',13],
            ['14201','LA UNIÓN',13],
            ['14202','FUTRONO',13],
            ['14203','LAGO RANCO',13],
            ['14204','RÍO BUENO',13],
            ['15101','ARICA',1],
            ['15102','CAMARONES',1],
            ['15201','PUTRE',1],
            ['15202','GENERAL LAGOS',1],
            ['16101','CHILLÁN',10],
            ['16102','BULNES',10],
            ['16103','CHILLÁN VIEJO',10],
            ['16104','EL CARMEN',10],
            ['16105','PEMUCO',10],
            ['16106','PINTO',10],
            ['16107','QUILLÓN',10],
            ['16108','SAN IGNACIO',10],
            ['16109','YUNGAY',10],
            ['16201','QUIRIHUE',10],
            ['16202','COBQUECURA',10],
            ['16203','COELEMU',10],
            ['16204','NINHUE',10],
            ['16205','PORTEZUELO',10],
            ['16206','RÁNQUIL',10],
            ['16207','TREGUACO',10],
            ['16301','SAN CARLOS',10],
            ['16302','COIHUECO',10],
            ['16303','ÑIQUÉN',10],
            ['16304','SAN FABIÁN',10],
            ['16305','SAN NICOLÁS',10],
            ['00000','DEF',17]
        ];
        $communes = array_map(function ($commune) use ($now) {
            return [
                'cod_commune' => $commune[0],
                'gloss_commune' => $commune[1],
                'region_id' => $commune[2],
                'updated_at' => $now,
                'created_at' => $now,
            ];
        }, $communes);
        DB::table('communes')->insert($communes);
    }

    public function insertVenues(): void
    {
        $now = now();
        $venues = [
            ['DEFAULT','default','(000) 000000','DEF',347],
            ['INACAP Arica','arica@inacap.cl','(58) 2578800','Avda Santa María # 2190',322],
            ['INACAP Iquique','iquique@inacap.cl','(57) 2 544900','Av. La Tirana #4310',1],
            ['INACAP Calama','calama@inacap.cl','(55) 2424600','Avda Granaderos # 3250',12],
            ['INACAP Antofagasta','antofagasta@inacap.cl','(55) 2424500','Avda Edmundo Pérez Zujovic # 11092',8],
            ['INACAP Copiapó','copiapo@inacap.cl','(52) 2524400','Yumbel 650',17],
            ['INACAP La Serena','infolaserena@inacap.cl','(51) 2553513','Av. Fco. de Aguirre 0389',26],
            ['INACAP Valparaíso','valparaiso@inacap.cl','(32) 2461200','Av. España 2250',41],
            ['INACAP Apoquindo','apoquindo@inacap.cl','(02) 24722500','Apoquindo 7282', 271],
            ['INACAP Maipú','maipu@inacap.cl','(02) 24722200','Av. Americo Vespucio #974', 276],
            ['INACAP Renca','renca@inacap.cl','(02) 28207200','Bravo de Saravia 2980', 285],
            ['INACAP Ñuñoa','comunicacionesnunoa@inacap.cl','(02) 24766100','Brown Norte 290', 277],
            ['INACAP Santiago Centro','santiagocentro@inacap.cl','(02) 24723000','Almirante Barroso 76', 258],
            ['INACAP Santiago Sur','santiagosur@inacap.cl','(02) 26526900','Av. Vicuña Mackenna 3864', 275],
            ['INACAP La Granja','lagranja@inacap.cl','0','Américo Vespucio 315', 268],
            ['INACAP Puente Alto','puentealto@inacap.cl','(562) 28162300','Av. Concha y Toro 2730', 290],
            ['INACAP Rancagua','rancagua@inacap.cl','(72) 2326300','Av. Nelson Pereira 2519', 79],
            ['INACAP Curicó','curico@inacap.cl','(75) 2547400','Archipiélago Juan Fernández 2010', 125],
            ['INACAP Talca','talca@inacap.cl','(71) 2528300','Av. San Miguel 3496', 112],
            ['INACAP Chillán','chillan@inacap.cl','(42) 2831800','Carretera Longitudinal Sur Nº 441', 326],
            ['INACAP Concepción - Talcahuano','concepcion@inacap.cl','(41) 2928500','Autopista Concepción Talcahuano 7421', 151],
            ['INACAP San Pedro de la Paz','sanpedro@inacap.cl','800202520','Calle Los Mañíos Nº3925', 149],
            ['INACAP Los Ángeles','losangeles@inacap.cl','(43) 2524800','Av. Ricardo Vicuña 825', 161],
            ['INACAP Temuco','temuco@inacap.cl','(45) 2916700','Luis Durand 02150', 175],
            ['INACAP Valdivia','valdivia@inacap.cl','(63) 2557900','Av. Pedro Aguirre Cerda 2115', 310],
            ['INACAP Osorno','osorno@inacap.cl','(64) 2557100','Av. René Soriano 2382', 226],
            ['INACAP Puerto Montt','puertomontt@inacap.cl','(65) 2364700','Av. Padre Harter 125', 207],
            ['INACAP Coyhaique','coyhaique@inacap.cl','(67) 2577710','Las Violetas 171', 237],
            ['INACAP Punta Arenas','puntaarenas@inacap.cl','(61) 2713100','Av. Bulnes Km. 4 Norte', 247],
        ];
        $venues = array_map(function ($venue) use ($now){
            return [
                'name' => $venue[0],
                'email' => $venue[1],
                'phone' => $venue[2],
                'address' => $venue[3],
                'commune_id' => $venue[4],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $venues);

        DB::table('venues')->insert($venues);
    }
}
