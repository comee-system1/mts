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
        $array_times[7][] = ['Opening Remarks','','08:40-08:50','Session 1 : Opening Remarks<br />Prof. Yoshiyuki Sato (Tohoku Institute of Technology, Japan)<br />
        Dr. Mitsuhiro Kanakubo (National Institute of Advanced Industrial Science and Technology, Japan)
        ','','',''];
        $array_times[7][] = ['','','08:50-10:40','Session 2 : Session I<br />
        Chair: Prof. Kenji Mishima (Fukuoka University, Japan) and Prof. Ikuo Ushiki (Hiroshima University, Japan)
        ','','',''];
        $array_times[7][] = ['IL01','T. Hiaki','08:50-09:20',
        '
        <b>Measurement of vapor-liquid equilibria for azeotropic systems</b>
        <br /><br />
        Toshihiko Hiaki*<br />
        Nihon University, Japan
         ','7a79c35f7ce0704dec63be82440c8182.pdf','https://www.yahoo.com/','sample.mp4'];

        $array_times[7][] = ['OP01','H. Matsuda','09:20-09:40','

        
        <b>Phase diagram of ternary mixtures water + n-alkane + non-ionic surfactant</b>
        <br />
        <br />
        Hiroyuki Matsuda<sup>*,1</sup>, Yuki Nakazato<sup>1</sup>, Rei Tsuchiya<sup>1</sup>, Yoshihiro Inoue<sup>1</sup>, Kiyofumi Kurihara<sup>1</sup>, Tomoya Tsuji<sup>2</sup>, Katsumi Tochigi<sup>1</sup>, Kenji Ochi<sup>1</sup>
        <br />
        <sup>1</sup>Nihon University, Japan
        <sup>2</sup>Universiti Teknologi Malaysia, Malaysia
        ','','',''];


        $array_times[7][] = ['OP02','T. Funazukuri','09:40-10:00','
        
        <b>Measurement and correlation of diffusion coefficientsof Cr(acac)3 in high temperature supercritical carbon dioxide</b>
        <br />
        <br />
        Minoru Yamamoto<sup>1</sup>, Junichi Sakabe<sup>1</sup>, Chang Yi Kong<sup>2</sup>, Toshitaka Funazukuri<sup>*1</sup>
        <br />
        <sup>1</sup>Chuo University, Japan		<sup>2</sup>Shizuoka University, Shizuoka
        
        ','','',''];



        $array_times[7][] = ['OP03','S. Ohe','10:00-10:20','
        <b>Vapor Pressure Prediction Method for Pure Substances</b>
        <br /> 
        <br /> 
        Shuzo Ohe<sup>*</sup>
        <br />
        Tokyo University of Science, Japan
        ','','',''];



        $array_times[7][] = ['OP04','M. Osada','10:20-10:40','
        <b>Prediction of solubility of organic compound for high-temperature water by machine learning
        </b>
        <br />
        <br />
        Mitsumasa Osada<sup>*</sup>, Kotaro Tamura<br />
        Shinshu University, Japan
        ','','',''];
        
        
        
        $array_times[7][] = ['Coffee Break','','10:40-11:00','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','11:00-11:50','Session 3 : Session II
        <br />
        Chair: Prof. Yoshiyuki Sato (Tohoku Institute of Technology, Japan) and Prof. Mitsumasa Osada (Shinshu University, Japan)        
        ','','',''];


        $array_times[7][] = ['IL02','H. Inomata','11:00-11:30','
        <b>
        Methodology for applying equations of state to phase equilibrium calculation for mixture
        </b>
        <br />
        <br />
        Hiroshi Inomata<sup>*</sup>
        Tohoku University, Japan
        ','','',''];




        $array_times[7][] = ['OP05','I. Ushiki','11:30-11:50','
        <b>
        Predicting the solubilities of acetylacetonate-type metalprecursors in supercritical CO2: Thermodynamic modeling using PC-SAFT</b>
        <br />
        <br />
        Ikuo Ushiki<sup>*</sup>, Ryo Fujimitsu, Azusa Miyajima, Shigeki Takishima
        <br />
        Hiroshima University, Japan
        ','','',''];



        $array_times[7][] = ['Lunch','','11:50-13:20','Session: Lunch','','',''];
        $array_times[7][] = ['','','13:20-15:10','Session 4: Session III
        <br />
        Chair: Prof. Taka-aki Hoshina (Nihon University, Japan) and Prof. Hiroshi Machida (Nagoya University, Japan)
        ','','',''];

        $array_times[7][] = ['IL03','R. Smith','13:20-13:50','
        
        <b>
        Application of Analytical Centrifugation toChemical Systems for Measurement of Properties and Phase Equilibria
        </b>
        <br />
        <br />
        Kotaro Oshima, Kentaro Nakamura, Natsuki Sato, Haixin Guo and Richard Lee Smith Jr.<sup>*</sup>
        <br />
        Tohoku University, Japan
        ','','',''];


        $array_times[7][] = ['OP06','Y. C. Hung','13:50-14:10','
        <b>
        Controlling the CO<sub>2</sub>-lipid liquid phaseseparation via process tuning and lipid structural design
        </b>
        <br />
        <br />
        
        Ying-Chieh Hung<sup>1</sup>, Yuna Tatsumi<sup>1</sup>, Chieh-Ming Hsieh<sup>2</sup>, Shiang-Tai Lin<sup>3</sup>, Yusuke Shimoyama<sup>*,1</sup>
        <br />
        <sup>1</sup>Tokyo Institute of Technology, Japan
        <sup>2</sup>National Central University, Taiwan
        <sup>3</sup>National Taiwan University, Taiwan

        ','','',''];



        $array_times[7][] = ['OP07','A. Duereh','14:10-14:30','
        <b>
        Development of CO<sub>2</sub>-assisted dispersibility of organic-inorganichybrid nanoparticles with expanded liquid solvent mixtures
        </b>
        <br />
        <br />
        Alif Duereh<sup>*,1</sup> , Masaki Ota<sup>1</sup> Yoshiyuki Sato<sup>2</sup>, 
        Hiroshi Inomata<sup>1</sup>
        <br />
        <sup>1</sup>Tohoku University, Japan
        <sup>1</sup>Tohoku Institute of Technology, Japan


        ','','',''];




        $array_times[7][] = ['OP08','A. R. Agustin','14:30-14:50','
        <b>
        Surface modification of nano-TiO2 with para-aminobenzoic acid in supercriticalcarbon dioxide for preventing aggregation of nanoparticles
        </b>
        <br />
        <br />
        
        Anggi Regiana Agustin, Kazuhiro Tamura<sup>*</sup>
        <br />
        Kanazawa University, Japan
        ','','',''];




        $array_times[7][] = ['OP09','Y. Orita','14:50-15:10','
        
        <b>
        Synthesis of decanoic acid-modified iron oxidenanocrystals using supercritical carbon dioxide as reaction medium
        </b>
        <br />
        <br />

        Yasuhiko Orita<sup>*</sup>, Keito Kariya, Thossaporn Wijakmatee, Yusuke Shimoyama
        <br />
        Tokyo Institute of Technology, Japan

        ','','',''];



        $array_times[7][] = ['Coffee Break','','15:10-15:30','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','15:30-16:30','
        Session 5: Session IV
        <br />
        Chair: Prof. Ana Soto (Universidade de Santiago de Compostela, Spain) and Prof. Alif Duereh (Tohoku University, Japan)
        ','','',''];
        
        $array_times[7][] = ['OP10','S. Tokunaga','15:30-15:50','
        <b>
        Production of spherical microparticles withEudragit L100 by the PGSS process in supercritical CO<sub>2</sub>-ethanol mixtures
        </b>
        <br />        
        <br />        
        Shinichi Tokunaga, Miyuki Nakamura, Tanjina Sharmin, Taku M. Aida, Kenji Mishima<sup>*</sup>
        <br />
        Fukuoka University, Japan

        ','','',''];



        $array_times[7][] = ['OP11','K. Mishima','15:50-16:10','
        <b>
        Application of direct sonication in water-CO<sub>2</sub> system
        </b>
        <br />
        <br />

        Kenji Mishima<sup>*</sup>, Tanjina Sharmin, Taku Michael Aida, Kento Ono
        <br />
        Fukuoka University, Japan

        ','','',''];



        $array_times[7][] = ['OP12','T. Sato','16:10-16:30','
        <b>
        Analysis of the mechanism of hydrothermal carbon dioxide fixation intoserpentine with estimation of equilibrium of chemical species
        </b>
        <br />
        <br />
        Takafumi Sato<sup>*</sup>, Seitaro Yamamoto, Naotsugu Itoh
        <br />
        Utsunomiya University, Japan
        
        ','','',''];



        $array_times[7][] = ['Coffee Break','','16:30-16:50','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','16:50-18:40','Session 6: Session V
        <br />
        Chair: Prof. Yoshio Iwai (Kyushu University, Japan) and Prof. Richard L. Smith (Tohoku University, Japan)
        ','','',''];
        $array_times[7][] = ['KL01','I. G. Economou','16:50-17:30','
        <b>
        Clean, High Quality Low Emission Fuels with Fischer-Tropsch Synthesis: A Multiscale Study of TransportProperties in Confined Systems
        </b>
        <br />
        <br />
        Ioannis G. Economou<sup>*,1,2</sup>, Konstantinos D. Papavasileiou<sup>1</sup>, Loukas D. Peristeras<sup>1</sup> Andreas Bick<sup>3</sup>
        <br />
        <sup>1</sup> Institute of Nanoscience and Nanotechnology, Greece
        <sup>2</sup>Texas A&M University at Qatar, Qatar
        <sup>3</sup>Scienomics SAS, France


        ','','',''];
        $array_times[7][] = ['KL02','A. Soto','17:30-18:10','
        <b>
        Phase Equilibria and Enhanced Oil Recovery
        </b>
        <br />
        <br />
        Ana Soto<sup>*</sup>
        Universidade de Santiago de Compostela, Spain
        
        ','','',''];

        /*
        $array_times[7][] = ['KL03','C. J. Peters','18:10-18:50','
        <b>
        Applications of deep eutectic solvents and gas hydrates in gas purifications
        </b>
        <br />
        <br />
        Samah E. E. Warrag<sup>1,2</sup>, 
        Muhammad Naveed Khanc<sup>3,4</sup>, 
        Cor J. Peters<sup>*,1,2,4</sup>
        <br />
        <sup>1</sup> Khalifa University of Science and Technology, United Arab Emirates
        <sup>2</sup> Eindhoven University of Technology, The Netherlands
        <sup>3</sup> University of Hafr Al Batin, Kingdom of Saudi Arabia
        <sup>4</sup>Colorado School of Mines, USA

        
        ','','',''];
*/

        /*
        $array_times[7][] = ['Coffee Break','','18:10-18:30','Session: Coffee Break','','',''];
        $array_times[7][] = ['','','18:30-19:30','Session 7: Session VI','','',''];
        
        $array_times[7][] = ['PL01','G. M. Kontogeorgis','18:30-19:30','Georgios M. Kontogeorgis. How can molecular concepts help in the development of more predictive advanced equations of state?','','',''];
*/




        $array_times[8][] = ['','','08:20-09:30','Session 8: Session VI
        <br />
        Chair: Prof. Hiroyuki Matsuda (Nihon University, Japan) and Prof. Hirotoshi Mori (Chuo University, Japan)
        ','','',''];
        $array_times[8][] = ['KL04','C. M<sup>c</sup>Cabe','08:20-09:00','
        <b>
        Exploring the effect of cholesterol on stratum corneum lipid assemblies
        </b>
        <br />
        <br />
        Parashara Shamaprasad, Chloe Frame, Timothy C. Moore, Chris Iacovella, Clare M<sup>c</sup>Cabe<sup>*</sup>
        <br />
        Vanderbilt University, USA

        ','','',''];

        
        $array_times[8][] = ['IL04','G. Xu','09:00-09:30','
        <b>
        Performance improvement on dynamic simulation for high pressure polyethylene synthesis by PC- SAFT
        </b>
        <br />
        <br />
        
        Gang Xu<sup>*</sup>, Nevin Gerek Ince
        <br />
        AVEVA, USA

        ','','',''];



        $array_times[8][] = ['Coffee Break','','09:30-09:50','Session : Coffee Break','','',''];
        $array_times[8][] = ['','','09:50-11:20','Session 9: Session VII
        <br />
        Chair: Dr. Gang Xu (AVEVA, USA) and Prof. Tomoya Tsuji (Universiti Teknologi Malaysia, Malaysia)
        ','','',''];


        $array_times[8][] = ['IL05','S.-T. Lin','09:50-10:20','
        <b>
        Improvements on the predictive COSMO-SAC model and its applications in process and produce design
        </b>
        
        <br />
        <br />
        Shiang-Tai Lin<sup>*,1</sup>, Cheih-Ming Hsieh<sup>2</sup>, Chang-Che Tsai<sup>1</sup>, Chen-Hsuan Huang<sup>1</sup>
        <br />
        <sup>1</sup>National Taiwan University
        <sup>2</sup>National Central University, Taiwan

        ','','',''];


        $array_times[8][] = ['OP13','H. Mori','10:20-10:40','
        <b>
        Ultimately large-scale ab initio molecular dynamics with effective fragment potential opens an era for predicting physicochemical properties of mixed liquids and supercritical fluids
        </b>
        <br />
        <br />
        
        Nahoko Kuroki<sup>1,2</sup>, Hirotoshi Mori<sup>*,1,3</sup>
        <br />
        <sup>1</sup> Chuo University, Japan
        <sup>2</sup> JST, ACT-X, Japan
        <sup>3</sup> Institute for Molecular Science, Japan

        ','','',''];





        $array_times[8][] = ['KL05','P. Cummings','10:40-11:20','
        <b>
        Molecular Modeling of Supercapacitor Systems
        </b>
        <br />
        <br />
        Peter T. Cummings<sup>*</sup>
        <br />
        Vanderbilt University, USA
        
        ','','',''];
        
        $array_times[8][] = ['Lunch','','11:20-13:00','Session : Lunch','','',''];
        $array_times[8][] = ['','','13:00-15:10','Session VIII
        <br />
        Chair: Prof. Shiang-Tai Lin (National Taiwan University, Taiwan) and Prof. Hidetaka Yamada (Kanazawa University, Japan)
        ','','',''];

        
        $array_times[8][] = ['IL06','T. Tsuji','13:00-13:30','
        <b>
        Mercury Solubility Measurements in Glycols and Amines for Natural Gas Processing Plant
        </b>
        <br />
        <br />
        Tomoya Tsuji<sup>*,1</sup>, 
        Junya Yamada<sup>2</sup>, 
        Midori Kawasaki<sup>2</sup>, 
        Machie Otsuka<sup>2</sup>, 
        Atsushi Kobayashi<sup>2</sup>
        <br />
        <sup>1</sup>Universiti Teknologi Malaysia, Malaysia	
        <sup>2</sup>INPEX Corporation, Japan

        
        ','','',''];


        $array_times[8][] = ['IL07','E. May','13:30-14:00','
        <b>
        Solids Formation Risk in Natural Gas, LNG and Liquid Hydrogen Production
        </b>
        <br />
        <br />

        Eric F. May<sup>*,1,2</sup>, Peter Metaxas1, Paul Stanwix<sup>1</sup>, Peter Falloon<sup>1</sup>, Vincent Lim<sup>1</sup>, Matthew Hopkins<sup>1</sup>, Catherine Sampson<sup>1</sup>, Arman Siahvashi<sup>1</sup>, Zachary Aman<sup>1</sup>
        <br />
        <br />
        
        <sup>1</sup> The University of Western Australia, Australia
        <br />
        <sup>2</sup> Future Energy Exports Cooperative Research Centre, Australia
        
        ','','',''];

        
        $array_times[8][] = ['IL08','K. Shin','14:00-14:30','
        <b>
        Molecular Behavior of 1-Pentanol Guest in the NH4F-doped Clathrate Hydrate
        </b>
        <br />
        <br />

        

        Byeonggwan Lee<sup>1.2</sup>, 
        Jeongtak Kim<sup>1,3</sup>, 
        Kyuchul Shin<sup>*,1</sup>, 
        Ki Hun Park<sup>4</sup>, 
        Minjun Cha<sup>4</sup>, 
        Saman Alavi<sup>*,5,6</sup>, 
        John A. Ripmeester<sup>6</sup>
        <br />
        <sup>1</sup> Kyungpook National University, Republic of Korea<br />
        <sup>2</sup> Korea Atomic Energy Research Institute, Republic of Korea<br />
        <sup>3</sup> Korea Institute of Energy Research, Republic of Korea<br />
        <sup>4</sup> Kangwon National University, Republic of Korea <br />
        <sup>5</sup> University of Ottawa, Canada	6 National Research Council of Canada, Canada
        
        ','','',''];


        $array_times[8][] = ['KL06','V. K. Rattan','14:30-15:10','
        <b>
        Kinetic viscosities prediction using ASOG-VISCO group contribution method for binary liquid mixtures
        </b>
        <br />
        <br />
        V. K. Rattan<sup>*,1</sup>, 
        Hiroyuki Matsuda<sup></sup>, 
        Katsumi Tochigi<sup>2</sup>, 
        Kiyofumi Kurihara<sup>2</sup>, 
        Toshitaka Funazukuri<sup>3</sup>
        <br />

        <sup>1</sup> GNA University, India	
        <sup>2</sup> Nihon University, Japan	
        <sup>3</sup> Chuo University, Japan


        ','','',''];


        
        $array_times[8][] = ['Coffee Break','','15:10-15:40','Session : Coffee Break','','',''];
        $array_times[8][] = ['','','15:40-17:30','Session IX
        <br />
        Chair: Prof. Daisuke Kodama (Nihon University, Japan) and Dr. Takeshi Furuya (National Institute of Advanced Industrial Science and Technology, Japan)

        ','','',''];


        $array_times[8][] = ['IL09','H. Yamada','15:40-16:10','
        <b>
        Physical Chemistry of Amine-Based Carbon Dioxide Separation
        </b>
        <br />
        <br />
        Hidetaka Yamada<sup>*</sup>
        <br />
        Kanazawa University, Japan

        ','','',''];




        $array_times[8][] = ['OP14','H. Machida','16:10-16:30','
        <b>
        High Throughput CO<sub>2</sub> Solubility Measurement in Amine Solution using HS-GC
        </b>
        <br />
        <br />
        Hiroshi Machida<sup>*</sup>, Keiichi Yanase, Tran Viet Bao Khuyen, Mikiro Hirayama, Koyo Norinaga
        <br />
        Nagoya University, Japan
        
        ','','',''];


        $array_times[8][] = ['OP15','T. Yamaguchi','16:30-16:50','
        <b>
        A new approach to the study of amine-CO<sub>2</sub> system based on the absolute reaction rate theory
        </b>
        <br />
        <br />
        Toru Yamaguchi<sup>*,1</sup>, Hidetaka Yamada<sup>2</sup>, Syohei Sanada<sup>1</sup>, Kenji Hori<sup>1,3</sup>
        <br />
        <sup>1</sup> Transition State Technology Co. Ltd., Japan
        <sup>2</sup> Kanazawa University, Japan
        <sup>3</sup> Yamaguchi University, Japan


        ','','',''];


        $array_times[8][] = ['OP16','K. Tran','16:50-17:10','
        <b>
        Temperature dependent of absorption heat in phase- change solvent in carbon dioxide capture
        </b>
        <br />
        <br />
        Tran Viet Bao Khuyen, Yamaguchi Tsuyoshi, Machida Hiroshi<sup>*</sup>, Koyo Norinaga
        <br />
        Nagoya University, Japan

        ','','',''];


        $array_times[8][] = ['OP17','H. Nishiumi','17:10-17:30','
        <b>
        Prediction of CO2 solubility in ionic liquids and glymes with modified generalized BWR Eos
        </b>
        <br />
        <br />
        Hideo Nishiumi<sup>*,1</sup>, Daisuke Kodama<sup>2</sup>
        <sup>1</sup> Hosei University, Japan
        <sup>2</sup> Nihon University, Japan


        ','','',''];


        $array_times[8][] = ['Coffee Break','','17:30 - 17:50','Session : Coffee Break','','',''];
        $array_times[8][] = ['','','17:50 - 19:20','Session X
        <br />
        Chair: Prof. Hiroshi Inomata (Tohoku University, Japan) and Dr. Masakazu Sasaki (Toyo Engineering Co, Japan)

        ','','',''];




        $array_times[8][] = ['IL10','B. Schmid','17:50 - 18:20','
        <b>
        DDBST and LTP – Your source for reliable thermophysical properties
        </b>
        <br />
        <br />
        Bastian Schmid<sup>*</sup>
        <br />
        DDBST GmbH, Germany
        ','','',''];

        $array_times[8][] = ['PL01','G M. Kontogeorgis','18:20 - 19:20','
        <b>
        How can molecular concepts help in the development of more predictive advanced equations of state?
        </b>
        <br />
        <br />
        Georgios M. Kontogeorgis<sup>*</sup>, Xiaodong Liang<br />
        Technical University of Denmark, Denmark
        ','','',''];




        $array_times[9][] = ['','','8:20 – 9:30','Session XI
        <br />
        Chair: Dr. Shigeo Oba (Applied Thermodynamics and Physical Properties Co., Ltd., Japan) and Dr. Takeshi Furuya (National Institute of Advanced Industrial Science and Technology, Japan)

        ','','',''];
        
        $array_times[9][] = ['IL11','C.-C. Chen','08:20-08:50','
        <b>
        Association-based Activity Coefficient Models for Electrolyte and Nonelectrolyte Solutions
        </b>
        <br />
        <br />
        Chau-Chyun Chen<sup>*</sup>
        <br />
        Texas Tech University, USA

        
        ','','',''];



        $array_times[9][] = ['KL07','Y. Iwai','08:50-09:30','

        <b>
        Prediction of vapor-liquid equilibria for multicomponent systems by a modified concentration dependent surface area parameter model
        </b>
        <br />
        <br />
        
        Yoshio Iwai<sup>*</sup>
        <br />
        Kyushu University, Japan


        ','','',''];


        $array_times[9][] = ['Coffee Break','','09:30-09:40','Session : Coffee Break','','',''];

        $array_times[9][] = ['Poster Session','Room A: PA01 - PA11 <br />Room B: PB01 - PB11','09:40-11:05','Session 14A: Flash Talk I Room A','','',''];

        
        $array_times[9][] = ['Lunch','','12:20-13:30','Session : Lunch','','',''];
        $array_times[9][] = ['Poster Session','Room A: PA12 - PA16 <br />Room B: PB12 - PB15','13:30-14:40','Session 16A: Flash Talk III Room A
        <br />
        Chair: Prof. Yusuke Shimoyama (Tokyo Institute of Technology, Japan) and Prof. Hiroyuki Miyamoto (Toyama Prefectural University, Japan)
        ','','',''];
        $array_times[9][] = ['Closing Remarks<br />Student Presentation Award','','14:50-15:10','Session 17: Closing Remarks, Student Presentation Award','','',''];





        // $array_poster[] = ['','','08:20-09:30','Session 13: Session XII'];
        // $array_poster[] = ['IL11','C.-C. Chen','08:20-08:50','Chau-Chyun Chen. Association-based Activity Coefficient Models for Electrolyte and Nonelectrolyte Solutions'];
        // $array_poster[] = ['KL07','Y. Iwai','08:50-09:30','Yoshio Iwai. Prediction of vapor-liquid equilibria for multicomponent systems by a modified concentration dependent surface area parameter model'];
        // $array_poster[] = ['','','09:30-09:40','Session : Coffee Break'];
        $array_poster[] = ['','','09:40-11:10','Poster Session with Flash Talk
        <br />
        Chair: Prof. Masaki Ota (Tohoku University, Japan) and Dr. Takashi Makino (National Institute of Advanced Industrial Science and Technology, Japan)
        ','','',''];

        $array_poster[] = ['PA01','T. Yamada','09:40-09:50','Tessei Yamada, Yuuhei Nakamura, Kyouhei Minai, Hiroyuki Miyamoto<sup>*</sup>
        <br />
        Toyama Prefectural University, Japan','Measurements and Modeling of Vapor-Liquid Equilibrium Properties for Low GWP refrigerants R1123/R1234yf/R32 Ternary Mixtures','','samplePDF.pdf','7a79c35f7ce0704dec63be82440c8182.pdf'];

        $array_poster[] = ['PA02','T. Tachibna','09:50-10:00','
        Takumi Tachibana, Hiroaki Matsukawa, Yuya Murakami, Atsushi Shono, Katsuto Otake<sup>*</sup>
        <br />
        Tokyo University of Science, Japan
        ','Phase Behavior of CO2/Toluene/PMMA ternary system','','',''];

        $array_poster[] = ['PA03','J. Shimada','10:00-10:10','
        Jin Shimada<sup>1</sup>, 
        Moe Yamada<sup>2</sup>, 
        Takeshi Sugahara<sup>*,1</sup>, 
        Atsushi Tani<sup>3</sup>, 
        Katsuhiko Tsunashima<sup>2</sup>, 
        Takayuki Hirai<sup>1</sup>
        <br />
        <sup>1</sup> Osaka University, Japan
        <sup>2</sup> National Institute of Technology, Wakayama Collage, Japan
        <sup>3</sup> Kobe University, Japan

        
        ','Thermodynamic properties of tetra-n-butylphosphonium dicarboxylate semiclathrate hydrates','','',''];


        $array_poster[] = ['PA04','K. Ikeda','10:10-10:20','
        Kosuke Ikeda<sup>1</sup>, Takuya Yasoyama<sup>1</sup>, Hiroyuki Miyamoto<sup>*,1</sup>, Sanehiro Muromachi<sup>2</sup>
        <br />
        <sup>1</sup> Toyama Prefectural University, Japan<br />
        <sup>2</sup> National Institute of Advanced Industrial Science and Technology, Japan

        ','Gas separation properties of semiclathrate hydrates for CH₄＋CO₂ mixed gas','','',''];


        $array_poster[] = ['PA05','S. Akiyama','10:20-10:30','
        Seika Akiyama<sup>*</sup>, Yingquan Hao, Yusuke Shimoyama<br />
        Tokyo Institute of Technology, Japan

        ','Host-guest chemistry of antibacterial molecular crystal in supercritical CO<sub>2</sub> with solvent','','',''];


        $array_poster[] = ['PA06','Y. Tatsumi','10:30-10:40','
        Yuna Tatsumi, Hao Yingquen, Yasuhiko Orita, Yusuke Shimoyama<sup>*</sup><br />
        Tokyo Institute of Technology, Japan
        ','Itraconazole cocrystallization in fatty acid under high- pressure CO<sub>2</sub>','','',''];

        $array_poster[] = ['','','10:40 – 11:05','PA 01 – PA 06 Questions','notcolor','',''];


        
        $array_poster[] = ['','','11:10-12:20','Session 15A: Flash Talk II Room A
        <br />
        Chair: Dr. Mitsuhiro Kanakubo (National Institute of Advanced Industrial Science and Technology, Japan) and Dr. Sanehiro Muromachi (National Institute of Advanced Industrial Science and Technology, Japan)
        ','','',''];

        $array_poster[] = ['PA07','A. Tokoro','11:10-11:20','
        Atuski Tokoro<sup>1</sup>, 
        Masaki Okada<sup>1</sup>, 
        Taka-aki Hoshina<sup>*,1</sup>, 
        Tomoya Tsuji<sup>2</sup>, 
        Takeshi Furuya<sup>3</sup>
        <br />
        <sup>1</sup> Nihon University, Japan<br />
        <sup>2</sup> Universiti Teknologi Malaysia (UTM) Kuala Lumpur, Malaysia<br />
        <sup>3</sup> The National Institute of Advanced Industrial Science and Technology (AIST), Japan
        
        ','Volumetric behavior of HFO-1234ze(E) + acetone liquid mixture at 303.2 K.','','',''];


        $array_poster[] = ['PA08','M. Yomori','11:20-11:30','
        Masamune Yomori<sup>1</sup>, 
        Hiroaki Matsukawa<sup>1</sup>, 
        Yuya Murakami<sup>2</sup>, 
        Atsushi Shono<sup>1</sup>, 
        Tomoya Tsuji<sup>2</sup>, 
        Katsuto Otake<sup>*,1</sup>
        <br />
        <sup>1</sup> Tokyo University of Science, Japan
        <sup>2</sup> University Technology Malaysia, Malaysia

        ','Measurement of the Density of Carbon Dioxide/Methanol and Ethanol Homogeneous Mixtures and Correlation with Equations of State','','',''];


        $array_poster[] = ['PA09','T. Homma','11:30-11:40','

        Taiki Homma<sup>*,1</sup>, 
        Masaki Ota<sup>1</sup>,
         Yoshiyuki Sato<sup>1,2</sup>, 
         Hiroshi Inomata<sup>1</sup>
        <br />
        <sup>1</sup> Tohoku University, Japan
        <sup>2</sup> Tohoku Institute of Technology, Japan

        ','Measurement and correlation of PVT for organic-inorganic hybrid nanoparticles','','',''];

        $array_poster[] = ['PA10','T. Wijakmatee','11:40-11:50','
        Thossaporn Wijakmatee, Yasuhiko Orita, Yusuke Shimoyama<sup>*</sup>
        <br />
        Tokyo Institute of Technology, Japan


        ','Micro-flow process of emulsification and supercritical fluid extraction of emulsion for stearic acid lipid nanoparticle production','','',''];



        $array_poster[] = ['PA11','T. Maeda','11:50-12:00','
        Tomoisa Maeda<sup>1</sup>, 
        Yusuke Asakuma<sup>*,1</sup>, 
        Shinya Ito, 
        Shuji Taue<sup>2</sup>, 
        Anita Hyde<sup>3</sup>, 
        Chi Phan<sup>3</sup>
        <br />
        <sup>1</sup> University of Hyogo, Japan
        <sup>2</sup> Kouchi Institute of Technology
        <sup>3</sup> Curtin University, Australia


        ','Study for hydration structure through the refractive index during microwave irradiation','','',''];

        $array_poster[] = ['','','12:00 – 12:20','PA 07 – PA 11 Questions','notcolor','',''];
        $array_poster[] = ['','','12:20-13:30','Session : Lunch','notcolor','',''];
        $array_poster[] = ['','Room A: PA12 - PA16 Room B: PB12 - PB15','13:30-14:40','Session 16A: Flash Talk III Room A
        <br />
        Chair: Prof. Yusuke Shimoyama (Tokyo Institute of Technology, Japan) and Prof. Hiroyuki Miyamoto (Toyama Prefectural University, Japan)
        ','','',''];


        $array_poster[] = ['PA12','M. Ota','13:30-13:40','
        Masaki Ota<sup>*,1</sup>, 
        Aruto Kuwahara<sup>1</sup>, 
        Yuki Hoshino<sup>1</sup>, 
        Yusuke Ueno<sup>1</sup>, 
        Shun Nomura<sup>1</sup>, 
        Yoshiyuki Sato<sup>1,2</sup>, 
        Richard Lee Smith Jr.<sup>1</sup>, 
        Hiroshi Inomata<sup>1</sup>

        <sup>1</sup> Tohoku University, Japan	
        <sup>2</sup> Tohoku Institute of Technology, Japan

        ','Development of a predictive Dimensionless Distribution coefficient (pDD) model for fractionation of Hops extracts','','',''];


        $array_poster[] = ['PA13','K. Tochigi','13:40-13:50','
        Hiroyuki Matsuda, Kiyofumi Kurihara, Katsumi Tochigi<sup>*</sup>
        <br />
        Nihon University, Japan

        ','Evaluation of solid-liquid equilibria for drug + water + cyclodextrin derivatives systems using activity coefficient model','','',''];

        $array_poster[] = ['PA14','Y. Watanabe','13:50-14:00','
        Yusuke Watanabe<sup>1</sup>, 
        Yosuke Shibata<sup>1</sup>, 
        Satoshi Sonobe<sup>1</sup>, 
        Yusuke Asakuma<sup>*,1</sup>, 
        Anita Hyde<sup>2</sup>, 
        Chi Phan<sup>2</sup>
        <br />
        <sup>1</sup> University of Hyogo, Japan
        <sup>2</sup> Curtin University, Australia

        ','Prediction for modification of liquid-liquid interface by energy concentration of microwave heating','','',''];

        $array_poster[] = ['PA15','T. Hoshina','14:00-14:10','
        Taka-aki Hoshina<sup>*,1</sup>, 
        Shohei Koizumi<sup>1</sup>, 
        Masaki Okada<sup>1</sup>, 
        Tomoya Tsuji<sup>2</sup>, 
        Toshihiko Hiaki<sup>1</sup>
        <br />
        <sup>1</sup> Nihon University, Japan
        <sup>2</sup> Universiti Teknologi Malaysia (UTM) Kuala Lumpur, Malaysia

        ','Dielectric properties of Liquefied Dimethyl Ether + Ethanol + Water Mixtures at 303.2 K','','',''];
        $array_poster[] = ['PA16','K. Tochigi','14:10-14:20','
        Katsumi Tochigi<sup>*,1</sup>, 
        Hiroyuki Matsuda<sup>1</sup>, 
        Kiyofumi Kurihara<sup>1</sup>, 
        Tomoya Tsuji<sup>2</sup>, 
        Toshitaka Funazukuri<sup>3</sup>, 
        V. K. Rattan<sup>4</sup>
        <br />
        <sup>1</sup> Nihon University, Japan
        <sup>2</sup> Universiti Teknologi Malaysia, Malaysia
        <sup>3</sup> Chuo University, Japan	
        <sup>4</sup> GNA University, India
        
        ','Prediction of thermal conductivities for liquid mixture using ASOG-ThermConduct model','','',''];

        $array_poster[] = ['','','14:20 – 14:40','PA 12 – PA 16 Questions','notcolor','',''];



        $array_poster[] = ['','','14:50-15:10','Closing Remarks and Student Poster Award
        <br />
        Prof. Yoshiyuki Sato (Tohoku Institute of Technology, Japan)
        <br />
        Dr. Mitsuhiro Kanakubo (National Institute of Advanced Industrial Science and Technology, Japan)

        ','','',''];




        $array_posterB[] = ['','','09:40-11:10','Poster Session with Flash Talk	Room B
        <br />
        Chair: Prof. Takafumi Sato (Utsunomiya University, Japan) and Prof. Tetsuo Honma (National Institute of Technology (KOSEN), Hachinohe College, Japan)
        ','','',''];
        $array_posterB[] = ['PB01','Y. Ainai','09:40-09:50','
        Yuto Ainai, Ayaka Taniguchi, Daisuke Kodama<sup>*</sup>
        <br />
        Nihon University, Japan
        ','CO<sub>2</sub> solubility of deep eutectic solvent consisting of choline chloride and ethylene glycol','','',''];

        $array_posterB[] = ['PB02','Y. Suzuki','09:50-10:00','
        Yuki Suzuki<sup>1</sup>, 
        Daisuke Kodama<sup>*,1</sup>, 
        Hirotoshi Mori<sup>2,3</sup>, 
        Nahoko Kuroki<sup>2,4</sup>, 
        Hidetaka Yamada<sup>5</sup>
        <br />
        <sup>1</sup> Nihon University, Japan
        <sup>2</sup> Chuo University, Japan
        <sup>3</sup> Institute for Molecular Science, Japan
        <sup>4</sup> JST, ACT-X, Japan
        <sup>5</sup> Kanazawa University, Japan

        
        ','CO<sub>2</sub>/hydrocarbon selectivity of phosphonium based ionic liquids','','',''];


        $array_posterB[] = ['PB03','R. Kinoshita','10:00-10:10','
        Ryoma Kinoshita<sup>1</sup>, Yusuke Tsuchida<sup>1</sup>, 
        Masahiko Matsumiya<sup>*,1</sup>, Yuji Sasaki<sup>2</sup>

        <br />
        ,<sup>1</sup> Yokohama National University, Japan
        ,<sup>2</sup> Japan Atomic Energy Agency, Japan

        ','Thermodynamic study of extraction behavior for precious metals using phosphonium-based ionic liquids','','',''];


        $array_posterB[] = ['PB04','T. Igosawa','10:10-10:20','
        Tatsuki Igosawa<sup>1</sup>, 
        Yusuke Tsuchida<sup>1</sup>, 
        Masahiko Matsumiya<sup>*,1</sup>, 
        and Yuji Sasaki<sup>2</sup>
        <br />
        <sup>1</sup> Yokohama National University, Japan	
        <sup>2</sup> Japan Atomic Energy Agency, Japan

        
        ','Thermodynamic study of W(VI) extraction using amine- based extractant and phosphonium ionic liquids','','',''];

        $array_posterB[] = ['PB05','A. Legaspi','10:20-10:30','
        Anna Legaspi<sup>*</sup>, Makoto Akizuki, Yoshito Oshima
        <br />
        The University of Tokyo, Japan

        ','Effects of Water in the Decarboxylation of Aromatic Carboxylic Acids in Supercritical Water','','',''];

        $array_posterB[] = ['PB06','N. Maeda','10:30-10:40','
        Naoya Maeda, Junichi Sakabe, Hirohisa Uchida<sup>*</sup>
        <br />
        Kanazawa University, Japan
        
        ','Calculation of Solubility of Organic Compounds in Supercritical Carbon Dioxide Using Machine Learning with Molecular Descriptors','','',''];

        $array_posterB[] = ['','','10:40 – 11:05','PB 01 – PB 06 Questions','notcolor','',''];



        $array_posterB[] = ['','','11:10-12:20','Session 15B: Flash Talk II Room B
        <br />
        Chair: Prof. Takeshi Sugahara (Osaka University, Japan) and Prof. Chang Yi Kong (Shizuoka University, Japan)
        ','','',''];

        $array_posterB[] = ['PB07','K. Matsubara','11:10-11:20','
        Koji Matsubara, Yoshio Iwai<sup>*</sup>
        <br />
        Kyushu University, Japan

        ','Simultaneous correlation of liquid-liquid equilibria for ternary systems and phase equilibria for constitutive binary systems by modified new activity coefficient model','','',''];


        $array_posterB[] = ['PB08','R. Suzuki','11:20-11:30','
        Rima Suzuki<sup>1</sup>, Nahoko Kuroki<sup>1,2</sup>, Hirotoshi Mori<sup>*,1,3</sup>
        <br />
        <sup>1</sup> Chuo University, Japan
        <sup>2</sup> JST, ACT-X, Japan
        <sup>3</sup> Institute for Molecular Science, Japan
        
        ','Anionic States play more important role: Electronic Structure Informatics of Gas- Phase Acidity Toward Fast and Precise Acids Design for Engineering','','',''];


        $array_posterB[] = ['PB09','M. Kitahara ','11:30-11:40','
        Masayuki Kitahara, Hiroaki Matsukawa, Yuya Murakami, Atsushi Shono, Katsuto Otake<sup>*,2</sup>
        <br />
        Tokyo University of Science, Japan
        ','Optimization of an Artificial Neural Network for Pure Component Parameters based on a Group Contribution Method of PC-SAFT EoS','','',''];

        $array_posterB[] = ['PB10','T. Kataoka','11:40-11:50','
        
        Taishi Kataoka, Yingquan Hao, Ying-Chieh Hung, Yusuke Shimoyama<sup>*</sup>
        Tokyo Institute of Technology, Japan

        ','Screening of phase-separation CO<sub>2</sub> absorbent using machine learning combined with molecular information','','',''];


        $array_posterB[] = ['PB11','Y. Hao','11:50-12:00','
        Yingquan HAO, Yusuke Shimoyama<sup>*</sup>
        <br />
        Tokyo Institute of Technology, Japan
        
        ','Prediction of Melting Point and Fusion Enthalpy of Cocrystal by Machine Learning combined with molecular informatics','','',''];


        $array_posterB[] = ['','','12:00 – 12:20','PB 07 – PB 11 Questions','notcolor','',''];
        $array_posterB[] = ['','','12:20-13:30','Session : Lunch','notcolor','',''];

        $array_posterB[] = ['','','13:30-14:30','Poster Session with Flash Talk	Room B
        <br />
        Chair: Hirohisa Uchida (Kanazawa University, Japan) and Prof. Makoto Akizuki (University of Tokyo, Japan)
        ','','',''];



        $array_posterB[] = ['PB12','T. Makino','13:30-13:40','
        Takashi Makino<sup>*,1</sup>, 
        Tatsuya Umecky<sup>2</sup>, 
        Mitsuhiro Kanakubo<sup>1</sup>
        <br />
        <sup>1</sup> National Institute of Advanced Industrial Science and Technology, Japan
        <sup>2</sup> Saga University, Japan
        ','Cation effects on physical properties of acetate-based ionic liquids','','',''];

        $array_posterB[] = ['PB13','Takeshi Sugahara','13:40 – 13:50','
        Takeshi Sugahara<sup>*,1</sup>, 
        Hironobu Machida<sup>2</sup>
        <br />
        <sup>1</sup> Osaka University, Japan
        <sup>2</sup> Panasonic Corporation, Japan
        ','Thermodynamic stabilities of clathrate hydrates including tetrahydrofuran and quaternary onium salts','','',''];
        
        $array_posterB[] = ['PB14','C. Y. Kong','13:50-14:00','
        Guoxiao Cai<sup>1</sup>, Wataru Katsumata<sup>1</sup>, Idzumi Okajima<sup>1</sup>, 
        Takeshi Sako<sup>1</sup>, Toshitaka Funazukuri<sup>2</sup>, 
        Chang Yi Kong<sup>*,1</sup>
        <br />
        <sup>1</sup> Shizuoka University, Japan
        <sup>2</sup> Chuo University, Japan

        
        ','Measurements of diffusion coefficient for triolein in various pressurized fluids with different viscosities','','',''];


        $array_posterB[] = ['PB15','T. Honma','14:00-14:10','
        Tetsuo Honma<sup>*,1</sup>, 
        Kouichiro Kurosawa<sup>1</sup>, 
        Tasuku Murata<sup>1,2</sup>, 
        Takafumi Sato<sup>2</sup>
        <br />
        <sup>1</sup> National Institute of Technology (KOSEN), Hachinohe College, Japan
        <sup>2</sup> Utsunomiya University, Japan

        
        ','Molecular dynamics study on nucleation process for supersaturated ZnO solutions in hydrothermal conditions','','',''];

        $array_posterB[] = ['PB16','T. Honma','14:10-14:20','
        Jia Lin Lee<sup>1</sup>, 
        Gun Hean Chong<sup>*,1</sup>, 
        Asami Kanno<sup>2</sup>, 
        Masaki Ota<sup>2</sup>, 
        Haixin Guo<sup>2</sup>, 
        Richard Lee Smith, Jr.<sup>2</sup>
        <br />
        <sup>1</sup> Universiti Putra Malaysia, Malaysia	
        <sup>2</sup> Tohoku University, Japan


        
        ','Correlation of solubilities in mixed-solvents with local-composition-regular solution theory','','',''];

        

        $array_posterB[] = ['','','14:20 – 14:40','PB 12 – PB 16 Questions','notcolor','',''];
        
        

        $array_weekday[7] = "Tuesday"; 
        $array_weekday[8] = "Wednesday"; 
        $array_weekday[9] = "Thursday"; 


        //rowspan
        $this->array_rowspan[2] = 5;
        $this->array_rowspan[9] = 2;
        $this->array_rowspan[13] = 5;
        $this->array_rowspan[20] = 3;
        $this->array_rowspan[25] = 2;

        $this->array_rowspan8[1] = 2;
        $this->array_rowspan8[5] = 3;
        $this->array_rowspan8[10] = 4;
        $this->array_rowspan8[16] = 5;
        $this->array_rowspan8[23] = 2;
        
        $this->array_rowspan9[1] = 2;


        $this->array_chair[2] = "K. Mishima<br />I. Ushiki";
        $this->array_chair[9] = "Y.Sato<br />M. Osada";
        $this->array_chair[13] = "T. Hoshina<br />H. Machida";
        $this->array_chair[20] = "A. Duereh<br />A. Soto";
        $this->array_chair[25] = "Y. Iwai<br />R. Smith";

        $this->array_chair8[1] = "H. Matsuda<br />H. Mori";
        $this->array_chair8[5] = "G. Xu<br />T. Tsuji";
        $this->array_chair8[10] = "S.-T. Lin<br />H. Yamada";
        $this->array_chair8[16] = "D. Kodama<br />T. Furuya";
        $this->array_chair8[23] = "M. Sasaki<br />H. Inomata";

        $this->array_chair9[1] = "S. Oba<br />T. Furuya";

        $this->array_times = $array_times;
        $this->array_poster = $array_poster;
        $this->array_posterB = $array_posterB;
        $this->array_weekday = $array_weekday;

        
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
                if($_REQUEST[ 'type' ] == "B"){
                    $poster = $this->array_posterB;
                    $array_poster = $this->array_posterB;
                }else{
                    $poster = $this->array_poster;
                    $array_poster = $this->array_poster;
                }
                
                $k = "";
                if($_REQUEST[ 'publication' ]){
                    $k = array_search($_REQUEST[ 'publication' ],array_column($array_poster,0));
                }
                if($_REQUEST[ 'endai' ]){
                    $endai = $_REQUEST['endai' ];
                    $k = key(preg_grep("/$endai/",array_column($array_poster,4)));
                }
                if($k){
                    $poster = [];
                    $poster[] = $array_poster[$k];
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

            $html['array_chair'] = $this->array_chair;
            $html['array_rowspan'] = $this->array_rowspan;
            $html['array_chair8'] = $this->array_chair8;
            $html['array_rowspan8'] = $this->array_rowspan8;
            $html['array_chair9'] = $this->array_chair9;
            $html['array_rowspan9'] = $this->array_rowspan9;
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
            $html[ 'weekday' ] = $this->array_weekday;
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
                $data['errmsg'] = "The login attempt failed. Either the user ID or password is invalid.";
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
                if(preg_match("/^PB/",$this->four)){
                    $list_station_cd= array_column($this->array_posterB, '0');
                    $key = array_search($id, $list_station_cd);
                    $posterdata = $this->array_posterB[$key];
                }else{
                    $list_station_cd= array_column($this->array_poster, '0');
                    $key = array_search($id, $list_station_cd);
                    $posterdata = $this->array_poster[$key];
                }

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