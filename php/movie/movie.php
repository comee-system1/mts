<?php
class movie{
    function __construct(){
        date_default_timezone_set('Asia/Tokyo');
		global $db;
        $this->db = $db;
		global $array_movie_date;
        $this->array_movie_date = $array_movie_date;
		global $array_movie;
        $this->array_movie = $array_movie;
        global $array_ippanKouenposter;
        $this->array_ippanKouenposter = $array_ippanKouenposter;
        global $array_judge;
        $this->array_judge = $array_judge;
        global $five;
        $this->five = $five;
        global $four;
        $this->four = $four;
        global $third;
        $this->third = $third;
        global $first;
        $this->first = $first;
        global $sec;
        $this->sec = $sec;

        global $tcpdf;
        $this->tcpdf = $tcpdf;
        global $pdf;
        $this->pdf = $pdf;

        //現在の利用確認
        $this->status = $this->db->getKagakuUser();
        $this->errorfile = "";
        /*
        if($status ["movie_status"] == 1){
            //エラーページ
            $this->errorfile = "error";
            $this->index();
            
        }
        */
        


        $key = 0;
        $array_times[7][] = ['Opening Remarks','','08:40-08:50','Session 1 : Opening Remarks','','',''];
        $array_times[7][] = ['','','08:50-10:40','Session 2 : Session I','','',''];
        $array_times[7][] = ['IL01','T. Hiaki','08:50-09:20','Toshihiko Hiaki. Measurement of Vapor-Liquid Equilibria for Azeotropic systems','7a79c35f7ce0704dec63be82440c8182.pdf','https://www.yahoo.com/','sample.mp4'];

        $array_times[7][] = ['OL01','H. Matsuda','09:20-09:40','Hiroyuki Matsuda, Yuki Nakazato, Rei Tsuchiya, Yoshihiro Inoue, Kiyofumi Kurihara, Tomoya Tsuji, Katsumi Tochigi and Kenji Ochi.Phase diagram of ternary mixtures water + n-alkane + non-ionic surfactant','','',''];
        $array_times[7][] = ['OL02','T. Funazukuri','09:40-10:00','Minoru Yamamoto, Junichi Sakabe, Chang Yi Kong and Toshitaka Funazukuri. Measurement and correlation of diffusion coefficientsof Cr(acac)3 in high temperature supercritical carbon dioxide','','',''];
        $array_times[7][] = ['OL03','S. Ohe','10:00-10:20','Shuzo Ohe. Vapor Pressure Prediction Method for Pure Substances','','',''];
        $array_times[7][] = ['OL04','M. Osada','10:20-10:40','Mitsumasa Osada and Kotaro Tamura. Prediction of solubility of organic compound for high-temperature water by machine learning','','',''];
        $array_times[7][] = ['Coffee Break','','10:40-11:00','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','11:00-11:50','Session 3 : Session II','','',''];
        $array_times[7][] = ['IL02','H. Inomata','11:00-11:30','Hiroshi Inomata. Methodology for Applying Equations of State to Phase Equilibrium Calculation for Mixtures','','',''];
        $array_times[7][] = ['OL05','I. Ushiki','11:30-11:50','Ikuo Ushiki, Ryo Fujimitsu, Azusa Miyajima and Shigeki Takishima. Predicting the solubilities of acetylacetonate-type metalprecursors in supercritical CO2: Thermodynamic modeling using PC-SAFT','','',''];
        $array_times[7][] = ['Lunch','','11:50-13:20','Session: Lunch','','',''];
        $array_times[7][] = ['','','13:20-15:10','Session 4: Session III','','',''];
        $array_times[7][] = ['IL03','R. Smith','13:20-13:50','Kotaro Oshima, Kentaro Nakamura, Natsuki Sato, Haixin Guo and Richard Smith. Application of Analytical Centrifugation toChemical Systems for Measurement of Properties and Phase Equilibria','','',''];
        $array_times[7][] = ['OL06','Y. C. Hung','13:50-14:10','Ying Chieh Hung, Yuna Tatsumi, Chieh Ming Hsieh, Shiang Tai Lin and Yusuke Shimoyama. Controlling the CO2-lipid liquid phaseseparation via process tuning and lipid structural design','','',''];
        $array_times[7][] = ['OL07','A. Duereh','14:10-14:30','Alif Duereh, Masaki Ota, Yoshiyuki Sato and Hiroshi Inomata. Development of CO2-assisted dispersibility of organic-inorganichybrid nanoparticles with expanded liquid solvent mixtures','','',''];
        $array_times[7][] = ['OL08','A. R. Agustin','14:30-14:50','Anggi Regiana Agustin and Kazuhiro Tamura.Surface modification of nano-TiO2 with para-aminobenzoic acid in supercriticalcarbon dioxide for preventing aggregation of nanoparticles','','',''];
        $array_times[7][] = ['OL09','Y. Orita','14:50-15:10','Yasuhiko Orita, Keito Kariya, Thossaporn Wijakmatee and Yusuke Shimoyama. Synthesis of decanoic acid-modified iron oxidenanocrystals using supercritical carbon dioxide as reaction medium','','',''];
        $array_times[7][] = ['Coffee Break','','15:10-15:30','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','15:30-16:30','Session 5: Session IV','','',''];
        $array_times[7][] = ['OL10','S. Tokunaga','15:30-15:50','Shinichi Tokunaga, Miyuki Nakamura, Tanjina Sharmin, Aida M. Taku and Kenji Mishima. Production of spherical microparticles withEudragit L100 by the PGSS process in supercritical CO2-ethanol mixtures','','',''];
        $array_times[7][] = ['OL11','K. Mishima','15:50-16:10','Kenji Mishima, Tanjina Sharmin, Taku Michael Aida and Kento Ono. Application of direct sonication in water-CO2 system','','',''];
        $array_times[7][] = ['OL12','T. Sato','16:10-16:30','Takafumi Sato, Seitaro Yamamoto and Naotsugu Itoh. Analysis of the mechanism of hydrothermal carbon dioxide fixation intoserpentine with estimation of equilibrium of chemical species','','',''];
        $array_times[7][] = ['Coffee Break','','16:30-16:50','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','16:50-18:10','Session 6: Session V','','',''];
        $array_times[7][] = ['KL01','I. G. Economou','16:50-17:30','Ioannis G. Economou. Clean, High Quality Low Emission Fuels with Fischer-Tropsch Synthesis: A Multiscale Study of TransportProperties in Confined Systems','','',''];
        $array_times[7][] = ['KL02','A. Soto','17:30-18:10','Ana Soto. Phase Equilibria and Enhanced Oil Recovery','','',''];
        $array_times[7][] = ['Coffee Break','','18:10-18:30','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','18:30-19:30','Session 7: Session VI','','',''];
        $array_times[7][] = ['PL01','G. M. Kontogeorgis','18:30-19:30','Georgios M. Kontogeorgis. How can molecular concepts help in the development of more predictive advanced equations of state?','','',''];

        $array_times[8][] = ['','','08:20-09:30','Session 8: Session VII','','',''];
        $array_times[8][] = ['KL03','C. McCabe','08:20-09:00','Clare McCabe. Test Test Test','','',''];
        $array_times[8][] = ['IL04','G. Xu','09:00-09:30','Gang Xu and Nevin Gerek Ince. Performance improvement on dynamic simulation for high pressure polyethylene synthesis by PC- SAFT','','',''];
        $array_times[8][] = ['Coffee Break','','09:30-09:50','Session : Coffee Break','','',''];
        $array_times[8][] = ['','','09:50-11:20','Session 9: Session VIII','','',''];
        $array_times[8][] = ['IL05','S.-T. Lin','09:50-10:20','Shiang-Tai Lin, Cheih-Ming Hsieh, Chang-Che Tsai and Chen-Hsuan Huang. Improvements on the Predictive COSMO-SAC Model and its Applications in Process and Produce Design','','',''];
        $array_times[8][] = ['OL13','H. Mori','10:20-10:40','Nahoko Kuroki and Hirotoshi Mori. Ultimately large-scale ab initio molecular dynamics with effective fragment potential opens an era for predicting physicochemical properties of mixed liquids and supercritical fluids','','',''];
        $array_times[8][] = ['KL04','P. Cummings','10:40-11:20','Peter Cummings. Molecular Modeling of Supercapacitor Systems','','',''];
        $array_times[8][] = ['Lunch','','11:20-13:00','Session : Lunch','','',''];
        $array_times[8][] = ['','','13:00-15:10','Session 10: Session IX','','',''];
        $array_times[8][] = ['IL06','T. Tsuji','13:00-13:30','Tomoya Tsuji, Junya Yamada, Midori Kawasaki, Machie Otsuka and Atsushi Kobayashi. Mercury Solubility Measurements in Glycols and Amines for Natural Gas Processing Plant','','',''];
        $array_times[8][] = ['IL07','E. May','13:30-14:00','Eric F. May. Solids Formation Risk in Natural Gas, LNG and Liquid Hydrogen Production','','',''];
        $array_times[8][] = ['IL08','K. Shin','14:00-14:30','Byeonggwan Lee, Jeongtak Kim, Kyuchul Shin, Ki Hun Park, Minjun Cha, Saman Alavi and John Ripmeester. Molecular Behavior of 1-Pentanol Guest in the NH4F-doped Clathrate Hydrate','','',''];
        $array_times[8][] = ['KL05','V. K. Rattan','14:30-15:10','V. K. Rattan. Correlation and Prediction of Kinematic Viscosities for Liquid Mixtures','','',''];
        $array_times[8][] = ['Coffee Break','','15:10-15:40','Session : Coffee Break','','',''];
        $array_times[8][] = ['','','15:40-17:30','Session 11: Session X','','',''];
        $array_times[8][] = ['IL09','H. Yamada','15:40-16:10','Hidetaka Yamada. Physical Chemistry of Amine-Based Carbon Dioxide Separation','','',''];
        $array_times[8][] = ['OL14','H. Machida','16:10-16:30','Hiroshi Machida, Keiichi Yanase, Tran Khuyen, Mikiro Hirayama and Koyo Norinaga. High Throughput CO2 Solubility Measurement in Amine Solution using HS-GC','','',''];
        $array_times[8][] = ['OL15','T. Yamaguchi','16:30-16:50','Toru Yamaguchi, Hidetaka Yamada, Syohei Sanada and Kenji Hori. A new approach to the study of amine-CO2 system based on the absolute reaction rate theory','','',''];
        $array_times[8][] = ['OL16','K. Tran','16:50-17:10','Khuyen Tran, Tsuyoshi Yamaguchi, Hiroshi Machida and Koyo Norinaga. Temperature dependent of absorption heat in phase- change solvent in carbon dioxide capture','','',''];
        $array_times[8][] = ['OL17','H. Nishiumi','17:10-17:30','Hideo Nishiumi and Daisuke Kodama. Prediction of CO2 solubility in ionic liquids and glymes with modified generalized BWR Eos','','',''];
        $array_times[8][] = ['Coffee Break','','17:30-17:50','Session : Coffee Break','','',''];
        $array_times[8][] = ['','','17:50-19:00','Session 12: Session XI','','',''];
        $array_times[8][] = ['KL06','C. J. Peters','17:50-18:30','Cor J. Peters. Applications of Deep Eutectic Solvents and Gas Hydrates in Gas Purifications','','',''];
        $array_times[8][] = ['IL10','B. Schmid','18:30-19:00','Bastian Schmid. DDBST and LTP – Your Source for Reliable Thermophysical Properties','','',''];


        $array_times[9][] = ['IL11','C.-C. Chen','08:20-08:50','Chau-Chyun Chen. Association-based Activity Coefficient Models for Electrolyte and Nonelectrolyte Solutions','','',''];
        $array_times[9][] = ['KL07','Y. Iwai','08:50-09:30','Yoshio Iwai. Prediction of vapor-liquid equilibria for multicomponent systems by a modified concentration dependent surface area parameter model','','',''];
        $array_times[9][] = ['Coffee Break','','09:30-09:40','Session : Coffee Break','','',''];
        $array_times[9][] = ['Poster Session','Room A: PA01 - PA11 <br />Room B: PB01 - PB11','09:40-11:10','Session 14A: Flash Talk I Room A','','',''];
        $array_times[9][] = ['Lunch','','12:20-13:30','Session : Lunch','','',''];
        $array_times[9][] = ['Poster Session','Room A: PA12 - PA16 <br />Room B: PB12 - PB15','13:30-14:40','Session 16A: Flash Talk III Room A','','',''];
        $array_times[9][] = ['Closing Remarks<br />Student Presentation Award','','14:50-15:10','Session 17: Closing Remarks, Student Presentation Award','','',''];


        // $array_poster[] = ['','','08:20-09:30','Session 13: Session XII'];
        // $array_poster[] = ['IL11','C.-C. Chen','08:20-08:50','Chau-Chyun Chen. Association-based Activity Coefficient Models for Electrolyte and Nonelectrolyte Solutions'];
        // $array_poster[] = ['KL07','Y. Iwai','08:50-09:30','Yoshio Iwai. Prediction of vapor-liquid equilibria for multicomponent systems by a modified concentration dependent surface area parameter model'];
        // $array_poster[] = ['','','09:30-09:40','Session : Coffee Break'];
        $array_poster[] = ['','','09:40-11:10','Session 14A: Flash Talk I Room A','','',''];
        $array_poster[] = ['PA01','T. Yamada','09:40-09:50','Tessei Yamada, Yuuhei Nakamura, Kyouhei Minai and Hiroyuki Miyamoto. ','Measurements and Modeling of Vapor-Liquid Equilibrium Properties for Low GWP refrigerants R1123/R1234yf/R32 Ternary Mixtures','sample1.mp4','samplePDF.pdf','7a79c35f7ce0704dec63be82440c8182.pdf'];
        $array_poster[] = ['PA02','T. Tachibna','09:50-10:00','Takumi Tachibna, Hiroaki Matsukawa, Yuya Murakami, Atsushi Shono and Katsuto Otake. ','Phase Behavior of CO2/Toluene/PMMA ternary system','','',''];
        $array_poster[] = ['PA03','J. Shimada','10:00-10:10','Jin Shimada, Moe Yamada, Takeshi Sugahara, Atsushi Tani, Katsuhiko Tsunashima and Takayuki Hirai. ','Thermodynamic properties of tetra-n-butylphosphonium dicarboxylate semiclathrate hydrates','','',''];
        $array_poster[] = ['PA04','K. Ikeda','10:10-10:20','Kosuke Ikeda, Takuya Yasoyama, Hiroyuki Miyamoto and Sanehiro Muromachi. ','Gas separation properties of semiclathrate hydrates for CH₄＋CO₂ mixed gas','','',''];
        $array_poster[] = ['PA05','S. Akiyama','10:20-10:30','Seika Akiyama, Yingquan Hao and Yusuke Shimoyama. ','Host-guest chemistry of antibacterial molecular crystal in supercritical CO2 with solvent','','',''];
        $array_poster[] = ['PA06','Y. Tatsumi','10:30-10:40','Yuna Tatsumi, Yingquan Hao, Yasuhiko Orita and Yusuke Shimoyama. ','Itraconazole cocrystallization in fatty acid under high- pressure CO2','','',''];
        $array_poster[] = ['','','09:40-11:10','Session 14B: Flash Talk I Room B','','',''];
        $array_poster[] = ['PB01','Y. Ainai','09:40-09:50','Yuto Ainai, Ayaka Taniguchi and Daisuke Kodama. ','CO2 solubility of deep eutectic solvent consisting of choline chloride and ethylene glycol','','',''];
        $array_poster[] = ['PB02','Y. Suzuki','09:50-10:00','Yuki Suzuki, Daisuke Kodama, Hirotoshi Mori, Nahoko Kuroki and Hidetaka Yamada. ','CO2/hydrocarbon selectivity of phosphonium based ionic liquids','','',''];
        $array_poster[] = ['PB03','R. Kinoshita','10:00-10:10','Ryoma Kinoshita, Yusuke Tsuchida, Masahiko Matsumiya and Yuji Sasaki. ','Thermodynamic study of extraction behavior for precious metals using phosphonium-based ionic liquids','','',''];
        $array_poster[] = ['PB04','T. Igosawa','10:10-10:20','Tatsuki Igosawa, Yusuke Tsuchida, Masahiko Matsumiya and Yuji Sasaki. ','Thermodynamic study of W(VI) extraction using amine- based extractant and phosphonium ionic liquids','','',''];
        $array_poster[] = ['PB05','A. Legaspi','10:20-10:30','Anna Legaspi, Makoto Akizuki and Yoshito Oshima. ','Effects of Water in the Decarboxylation of Aromatic Carboxylic Acids in Supercritical Water','','',''];
        $array_poster[] = ['PB06','N. Maeda','10:30-10:40','Hirohisa Uchida, Naoya Maeda and Junichi Sakabe. ','Calculation of Solubility of Organic Compounds in Supercritical Carbon Dioxide Using Machine Learning with Molecular Descriptors','','',''];
        $array_poster[] = ['','','11:10-12:20','Session 15A: Flash Talk II Room A','','',''];
        $array_poster[] = ['PA07','A. Tokoro','11:10-11:20','Atsuki Tokoro, Masaki Okada, Taka-Aki Hoshina, Tomoya Tsuji and Takeshi Furuya. ','Volumetric behavior of HFO-1234ze(E) + acetone liquid mixture at 303.2 K.','','',''];
        $array_poster[] = ['PA08','M. Yomori','11:20-11:30','Masamune Yomori, Hiroaki Matsukawa, Yuya Murakami, Atsushi Shono, Tomoya Tsuji and Katsuto Otake. ','Measurement of the Density of Carbon Dioxide/Methanol and Ethanol Homogeneous Mixtures and Correlation with Equations of State','','',''];
        $array_poster[] = ['PA09','T. Homma','11:30-11:40','Taiki Homma, Masaki Ota, Yoshiyuki Sato and Hiroshi Inomata. ','Measurement and correlation of PVT for organic-inorganic hybrid nanoparticles','','',''];
        $array_poster[] = ['PA10','T. Wijakmatee','11:40-11:50','Thossaporn Wijakmatee, Yasuhiko Orita and Yusuke Shimoyama. ','Micro-flow process of emulsification and supercritical fluid extraction of emulsion for stearic acid lipid nanoparticle production','','',''];
        $array_poster[] = ['PA11','T. Maeda','11:50-12:00','Tomoisa Maeda and Yusuke Asakuma. ','Study for hydration structure through the refractive index during microwave irradiation','','',''];
        $array_poster[] = ['','','11:10-12:20','Session 15B: Flash Talk II Room B','','',''];
        $array_poster[] = ['PB07','K. Matsubara','11:10-11:20','Koji Matsubara and Yoshio Iwai. ','Simultaneous correlation of liquid-liquid equilibria for ternary systems and phase equilibria for constitutive binary systems by modified new activity coefficient model','','',''];
        $array_poster[] = ['PB08','R. Suzuki','11:20-11:30','Rima Suzuki, Nahoko Kuroki and Hirotoshi Mori. ','Anionic States play more important role: Electronic Structure Informatics of Gas- Phase Acidity Toward Fast and Precise Acids Design for Engineering','','',''];
        $array_poster[] = ['PB09','M. Kitahara ','11:30-11:40','Masayuki Kitahara, Hiroaki Matsukawa, Yuya Murakami and Katsuto Otake. ','Optimization of an Artificial Neural Network for Pure Component Parameters based on a Group Contribution Method of PC-SAFT EoS','','',''];
        $array_poster[] = ['PB10','T. Kataoka','11:40-11:50','Taishi Kataoka, Yingquan Hao, Ying Chieh Hung and Yusuke Shimoyama. ','Screening of phase-separation CO2 absorbent using machine learning combined with molecular information','','',''];
        $array_poster[] = ['PB11','Y. Hao','11:50-12:00','Yingquan Hao and Yusuke Shimoyama. ','Prediction of Melting Point and Fusion Enthalpy of Cocrystal by Machine Learning combined with molecular informatics','','',''];
        $array_poster[] = ['','','12:20-13:30','Session : Lunch','','',''];
        $array_poster[] = ['Poster Session','Room A: PA12 - PA16 Room B: PB12 - PB15','13:30-14:40','Session 16A: Flash Talk III Room A','','',''];
        $array_poster[] = ['PA12','M. Ota','13:30-13:40','Masaki Ota, Aruto Kuwahara, Yuki Hoshino, Yusuke Ueno, Shun Nomura, Yoshiyuki Sato, Richard L. Smith and Hiroshi Inomata. ','Development of a predictive Dimensionless Distribution coefficient (pDD) model for fractionation of Hops extracts','','',''];
        $array_poster[] = ['PA13','K. Tochigi','13:40-13:50','Hiroyuki Matsuda, Kiyofumi Kurihara and Katsumi Tochigi. ','Evaluation of solid-liquid equilibria for drug + water + cyclodextrin derivatives systems using activity coefficient model','','',''];
        $array_poster[] = ['PA14','Y. Watanabe','13:50-14:00','Yusuke Watanabe and Yusuke Asakuma. ','Prediction for modification of liquid-liquid interface by energy concentration of microwave heating','','',''];
        $array_poster[] = ['PA15','T. Hoshina','14:00-14:10','Taka-Aki Hoshina, Shohei Koizumi, Masaki Okada, Tomoya Tsuji and Toshihiko Hiaki. ','Dielectric properties of Liquefied Dimethyl Ether + Ethanol + Water Mixtures at 303.2 K','','',''];
        $array_poster[] = ['PA16','K. Tochigi','14:10-14:20','Katsumi Tochigi, Hiroyuki Matsuda, Kiyofumi Kurihara, Tomoya Tsuji, Toshitaka Funazukuri and V. K. Rattan. ','Prediction of thermal conductivities for liquid mixture using ASOG-ThermConduct model','','',''];
        $array_poster[] = ['','','13:30-14:30','Session 16B: Flash Talk III Room B','','',''];
        $array_poster[] = ['PB12','T. Makino','13:30-13:40','Takashi Makino, Tatsuya Umecky and Mitsuhiro Kanakubo. ','Cation effects on physical properties of acetate-based ionic liquids','','',''];
        $array_poster[] = ['PB13','T. Sugahara','13:40-13:50','Takeshi Sugahara and Hironobu Machida. ','Thermodynamic stabilities of clathrate hydrates including tetrahydrofuran and quaternary onium salts','','',''];
        $array_poster[] = ['PB14','C. Y. Kong','13:50-14:00','Guoxiao Cai, Wataru Katsumata, Idzumi Okajima, Takeshi Sako, Toshitaka Funazukuri and Chang Yi Kong. ','Measurements of diffusion coefficient for triolein in various pressurized fluids with different viscosities','','',''];
        $array_poster[] = ['PB15','T. Honma','14:00-14:10','Tetsuo Honma, Youichirou Kurosawa, Tasuku Murata and Takafumi Sato. ','Molecular dynamics study on nucleation process for supersaturated ZnO solutions in hydrothermal conditions','','',''];
        $array_poster[] = ['','','14:50-15:10','Session 17: Closing Remarks, Student Presentation Award','','',''];


/*
        //ポスターデータ
        $array_poster[] = [
            'publication'=>'p0001',
            'endainame'=>'ポスターサンプル',
            'sub'=>'',
            'syozokuKikanRyaku'=>'九工大院工',
            'tyosya_name'=>'○竹中 繁織 ・ 佐藤 しのぶ ・ Zou Tingting',
            'fileUpdate_flash_ext'=>'sample1.mp4',
            'fileUpdate_poster_ext'=>'PC112-P0227-CSJ-TOHOKU20-20200824152633.pdf',
            'fileUpdate_ext'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
        ];
        //ポスターデータ
        $array_poster[] = [
            'publication'=>'p0002',
            'endainame'=>'ポスターサンプル2',
            'sub'=>'',
            'syozokuKikanRyaku'=>'九工大院工2',
            'tyosya_name'=>'○竹中 繁織 ・ 佐藤 しのぶ ・ Zou Tingting',
            'fileUpdate_flash_ext'=>'sample1.mp4',
            'fileUpdate_poster_ext'=>'PC112-P0227-CSJ-TOHOKU20-20200824152633.pdf',
            'fileUpdate_ext'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
        ];
*/
        $this->array_times = $array_times;
        $this->array_poster = $array_poster;

        
    }
    
    public function index(){
        //エラーページ
        if($this->errorfile){
            $data[ 'file' ] = $this->errorfile;
            unset($_SESSION[ 'movies' ]);
        }
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            //一覧ページに遷移
            header("Location:/movie/list");
            exit();
            
        }else{
            unset($_SESSION[ 'movies' ]);
            //ログインしていないとき
            $data = $this->logincheck();
        }
        return $data;
    }
    public function logout(){
        unset($_SESSION[ 'movies' ]);
        header("Location:/movie/");
        exit();
    }
    /***********
     * mp4の表示
     */
    public function flash(){
        //拡張子を消す
        $ex = explode(".",$this->third);
        $mp4 = $ex[0].".mp4";

        $html['mp4'] = $mp4;
        return $html;
    }
    /********
     * 一覧
     */
    public function list(){

/*
        //ログインしているときのみ
        if($_SESSION[ 'movies' ][ 'selecter' ] != 1 ){
            if($this->status["movie_status"] == 1 ){
                //エラーページ
                $this->errorfile = "error";
                $this->index();
                
            }
        }
  */      
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            if($_REQUEST[ 'ajax' ]){
                //ポスター発表データ取得
                $poster = $this->array_poster;
                $k = "";
                if($_REQUEST[ 'publication' ]){
                    $k = array_search($_REQUEST[ 'publication' ],array_column($this->array_poster,0));
                }
                if($_REQUEST[ 'endai' ]){
                    $endai = $_REQUEST['endai' ];
                    $k = key(preg_grep("/$endai/",array_column($this->array_poster,4)));
                }
                if($k){
                    $poster = [];
                    $poster[] = $this->array_poster[$k];
                }
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($poster);
                exit();
            }
            //審査判定
            if($_REQUEST[ 'judgeAjax' ]){
                $table = "sanka_judge";
                //備考の登録
                if($_REQUEST[ 'other' ]){
                    $edit = [];
                    $edit[ 'where' ][ 'id' ] = $_REQUEST[ 'id' ];
                    $edit[ 'edit' ][ 'other' ] = $_REQUEST[ 'other' ];

                }else
                if(strlen($_REQUEST[ 'recommen' ]) > 0 ){
                    //一旦全てを0にする
                    $edit = [];
                    $edit[ 'where' ][ 'code' ] = $_SESSION['movies'][ 'code' ];
                    $edit[ 'edit' ][ 'recomen' ] = 0;
                    
                    $this->db->editUserData($table,$edit);

                    $edit = [];
                    $edit[ 'where' ][ 'id' ] = $_REQUEST[ 'id' ];
                    $edit[ 'edit' ][ 'recomen' ] = $_REQUEST[ 'recommen' ];
                }else{
                    $edit = [];
                    $edit[ 'where' ][ 'id' ] = $_REQUEST[ 'id' ];
                    $edit[ 'edit' ][ 'result_select' ] = $_REQUEST[ 'judge' ];
                }
                $this->db->editUserData($table,$edit);
                exit();
            }

            //出力確認
            //出力は一度のみ
            $where = [];
            $where[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $check = $this->db->getRecipeLog($where);

            if(empty($check)){
                $html['recipeflag'] = true;
            }else{
                $html['recipeflag'] = false;
            }
            $html['array_movie'] = $this->array_movie;
            $html['array_movie_date'] = $this->array_movie_date;
            $html['array_ippanKouenposter'] = $this->array_ippanKouenposter;
            $html['array_judge'] = $this->array_judge;
            $html['array_times'] = $this->array_times;

            
            //説明文の取得
            $explain = $this->db->getMovieExplain();
            $html['explain'] = $explain;

            $list = $this->db->getMovieList();
            $html['list']=$list;

            //審査員のときのみ
            if($_SESSION[ 'movies' ][ 'judge' ] == "on"){
                $where = [];
                $where[ 'code' ] = $_SESSION[ 'movies' ][ 'code' ];
                $judgelist = $this->db->checkJudgeData($where);
                $html['judgelist']=$judgelist;
                  
            }

            return $html;
        }else{
            header("Location:/movie/");
            exit();
        }
    }
    /********
    * session画面
    */
    public function session(){
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            //説明文
            $explain = $this->db->getMovieExplain();
            $html['explain'] = $explain[ 'sessionlist_text' ];

            /*
            //講演者データ取得
            $data=[];
            foreach($this->array_movie_date as $key=>$val){
                $ex = explode("-",$key);
                $day = $ex[2];
                $where = [];
                $where['day'] = $day;
                $data[$day] = $this->db->getSessionData($where);

            }
            //動画情報取得
            $html[ 'zoom' ] = $this->db->getMoveData();
            $html['list'] = $data;          
            */
            $html[ 'list' ] = $this->array_times;
            return $html;
        }else{
            header("Location:/movie/");
            exit();
        }
    }
    
    public function logincheck(){
        //ログインチェック
        $data = [];
        if(filter_input(INPUT_POST,"login")){    


            $user = $this->db->getMovieLogin();

            if($user){
                $_SESSION[ 'movies' ][ 'login' ] = "on";
                $_SESSION[ 'movies' ][ 'id' ] = $user[ 'id' ];
                $_SESSION[ 'movies' ][ 'num' ] = $user[ 'num' ];
                $_SESSION[ 'movies' ][ 'code' ] = $user[ 'code' ];
                $_SESSION[ 'movies' ][ 'selecter' ] = $user[ 'selecter' ];
                //審査員かどうかの確認
                if($this->db->checkJudgeMan($user)){
                    $_SESSION[ 'movies' ][ 'judge' ] = "on";
                }
                
                header("Location:/movie/list");
                exit();
            }else{
                $data['errmsg'] = "ログインに失敗しました。";
            }

        }
        
        return $data;
        
    }
    
    /***************
     * チャット
     */
    public function chat(){
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            $set = [];
            
            //ポスターの時
            if($this->third == "poster"){
                $id = $this->four;
                $list_station_cd= array_column($this->array_poster, '0');
                $key = array_search($id, $list_station_cd);
                $posterdata = $this->array_poster[$key];
                $set[ 'endainame' ] = $posterdata[4];
            }else{
                //チャット登録
                $id = $this->five;
                //取得データの保存を行う
                $posterdata = $this->array_times[$this->third][$this->four];
                $set[ 'endainame' ] = $posterdata[3];
            }
            $set[ 'code' ] = $posterdata[0];
            $set[ 'snum' ] = $posterdata[0];
            $set[ 'num' ] = $posterdata[0];
            $set[ 'publication' ] = $posterdata[0];
            $table = "kagaku_endai";
            //ポスター発表データ取得
            $_SESSION[ 'movies' ][ 'endai_code' ] = $id;       

            if(!$this->db->getPosterList($id)){
                $this->db->setUserData($table,$set);
            }
            
            if($_REQUEST[ 'ajax' ] == "on"){
                $set = [];
                $set['note'] = $_REQUEST[ 'note' ];
                $set[ 'kagaku_sanka_code' ] = $_SESSION[ 'movies' ][ 'code' ];
                $set[ 'endai_code' ] = $this->third;
                $set[ 'regist_date' ] = date("Y-m-d H:i:s");
                $set[ 'regist_ts' ] = date("Y-m-d H:i:s");
                $table = "question";
                $this->db->setUserData($table,$set);
                exit();
            }
            //一覧表示
            if($_REQUEST[ 'ajax' ] == "list"){
                $where = [];
                $where[ 'code' ] = $_REQUEST[ 'code' ];
                $list = $this->db->getQuestionData($where);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($list);
                exit();
            }
            
            //チャット削除
            if($_REQUEST[ 'ajax' ] == "delete"){
                $edit=[];
                $edit['where']['id'] = $_REQUEST[ 'id' ];
                $edit['where']['kagaku_sanka_code'] =$_SESSION[ 'movies' ][ 'code' ];
                $edit[ 'edit' ]['status'] = 0;
                $table = "question";
                $this->db->editUserData($table,$edit);
                exit();
            }
            //ポスター発表データ取得            
            $poster = $this->db->getPosterList($id);


            //返答登録
            if($_REQUEST[ 'ajax' ] == "replay"){
                $set = [];
                //演題発表者が返答をするとき
                if($_SESSION['movies'][ 'num' ] == $poster[0][ 'snum' ]){
                    $set['replay_flag'] = 1;
                    $set['replay_pcode'] = $poster[0][ 'code' ];
                }

                
                $set['note'] = $_REQUEST[ 'note' ];
                $set[ 'kagaku_sanka_code' ] = $_SESSION[ 'movies' ][ 'code' ];
                $set[ 'question_id' ] = $_REQUEST[ 'question_id' ];
                $set[ 'regist_date' ] = date("Y-m-d H:i:s");
                $set[ 'regist_ts' ] = date("Y-m-d H:i:s");
                $table = "replay";
                $this->db->setUserData($table,$set);
                exit();
            }
            //返答表示
            if($_REQUEST[ 'ajax' ] == "replaylist"){
                $where = [];
                $where[ 'question_id' ] = $_REQUEST[ 'question_id' ];
                $list = $this->db->getReplayData($where);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($list);
                exit();
            }
            //説明文
            $explain = $this->db->getMovieExplain();

            $html['id'] = $id;
            $html['code'] = $_SESSION['movies'][ 'code' ];
            $html['explain'] = $explain['chat_text'];
            $html['endainame'] = $poster[0]['endainame'];
            $html['tyosya_name'] = $poster[0]['tyosya_name'];
            $html['syozokuKikanRyaku'] = $poster[0]['syozokuKikanRyaku'];
            $html['publication'] = $poster[0]['publication'];
            return $html;
            
        }else{
            header("Location:/movie/");
            exit();
        }
        
    }

    /********************
     * 領収書出力
     */
    public function recipe(){
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            //出力確認
            //出力は一度のみ
            $where = [];
            $where[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $check = $this->db->getRecipeLog($where);

        

            //領収書出力データ保存
            $set = [];
            $set[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $set[ 'regist_ts' ] = date('Y-m-d H:i:s');
            $table = "recipe_output";
            $this->db->setUserData($table,$set);

            $where = [];
            $where[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $recipe = $this->db->getRecipe($where);
            
            $pdf = $this->pdf;
            $pdf->setSourceFile('./lib/recipe_tmp.pdf');
            
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage('L', 'A4');
            $importPage = $pdf->importPage(1);
            $pdf->useTemplate($importPage, 0, 0);
            $pdf->SetFont("kozminproregular", "", 12);
            $pdf->Text(48.8, 56.4, $recipe['name1'].$recipe['name2']);
            $pdf->Text(108.5, 70.8, number_format($recipe['total']));
            if(!empty($check)){
                $pdf->Text(149, 39, "再発行");
            }
            $day = date("d");
            $pdf->SetFontSize(11.5);
            $pdf->Text(204.0, 47.4, $day);
            
            $pdf->Output("rep-".date('Ymdhis').".pdf", "D");
            

            exit();
        }else{
            header("Location:/movie/");
            exit();
        }
    }

}