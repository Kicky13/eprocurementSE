<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0"><strong>Contractor SHE Mangement System (CSMS)</strong></h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url($menu[0][1]['URL']);?>"><?= lang("Dashboard", "Dashboard"); ?></a>
                            </li>
                            <li class="breadcrumb-item active">CSMS
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="verif"><i class=" fa fa-check success"></i><?= lang(" Data Terverifikasi, Menunggu verifikasi berikutnya", "Data is verified, Waiting for next verification") ?></div>
                <div class="verif_app"><i class=" fa fa-check success"></i><?= lang("Data Telah Terverifikasi, SLKA terbit", "Data is verified, SLKA has been published") ?></div>
                <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Anda ditolak, Mohon perbaiki data anda", "Your Data is rejected, Please update your data ") ?></div>
            </div>
        </div>
        <div class="content-detached content-left">
            <div class="content-body">
                <section id="description">
                    <div class="card">
                        <div class="card-header" id="CSMS">
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data CSMS ditolak", "CSMS data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content CSMS">
                            <div class="card-body">
                                <form id="form" action="#" class="steps-validation wizard-circle">
                                    <h6><?= lang("Bagian 1", "Section 1"); ?></h6>
                                    <h6><?= lang("Bagian 2", "Section 2"); ?></h6>
                                    <h6><?= lang("Bagian 3", "Section 3"); ?></h6>
                                    <h6><?= lang("Bagian 4", "Section 4"); ?></h6>
                                    <h6><?= lang("Bagian 5", "Section 5"); ?></h6>
                                    <h6><?= lang("Bagian 6", "Section 6"); ?></h6>
                                    <h6><?= lang("Bagian 7", "Section 7"); ?></h6>
                                    <h6><?= lang("Bagian 8", "Section 8"); ?></h6>
                                    <h6><?= lang("Bagian 9", "Section 9"); ?></h6>
                                    <h6><?= lang("Selesai", "Finish") ?></h6>

                                    <fieldset id="bagian1" class="col-12" class="white-bg">
                                        <h2 class="m-b-md"><?= lang("Kepemimpinan dan Komitmen Manajemen", "Leadership and Top Management Commitment"); ?></h2>
                                        <div class="row">
                                            <?= areatext("1a", "", "<strong>a) Bagaimana manajer senior di manajemen puncak terlibat secara pribadi dalam manajemen SHE?</strong>", "<strong>a) How are senior managers in top management personally involve in SHE management ?</strong>")
                                            ?>
                                            <label class="form-label"><?= lang("<strong>b) Berikan bukti komitmen di semua tingkat organisasi dengan:</strong>", "<strong>b) Provide evidence of commitment at all levels of the organization by:</strong>")
                                            ?></label>
                                            <?= areatext("1b1", "", "(i) Nyatakan target perusahaan tahun ini untuk kinerja SHE", "(i) Stating this year's company targets for SHE performance") ?>
                                            <?=
                                            areatext("1b2", "", "(ii) Jelaskan bagaimana Anda memastikan bahwa organisasi Anda mengerti dan berkomitmen untuk memenuhi target SHE perusahaan Anda", "(ii) Describe how you ensure that your organization understands and is committed to deliver on your company SHE targets")
                                            ?>
                                            <?= areatext("1c", "", "<strong>c) Bagaimana Anda mempromosikan budaya positif terhadap masalah SHE?</strong>", "<strong>c) How do you promote a positive culture towards SHE matters ?</strong>")
                                            ?>
                                            <?= areatext("1d", "", "<strong>d) Berikan bagan organisasi Anda saat ini</strong>", "<strong>d) Provide your current organization chart</strong>")
                                            ?>
                                        </div>
                                    </fieldset>
                                    <fieldset id="bagian2" class="col-12">
                                        <h2 class="m-b"><?= lang("Tujuan Kebijakan dan Strategi ", "Policy and Strategic Objectives"); ?></h2>
                                        <div class="row">
                                            <!--2.1-->
                                            <label class="form-label"><?= lang("<strong> 2.1. Kebijakan dan Dokumen SHE</strong>", "<strong>2.1.SHE Policy and Document</strong>")
                                            ?></label>
                                            <?=
                                            areatext("2_1a", "", "a) Apakah perusahaan Anda memiliki dokumen kebijakan SHE yang diterapkan di wilayah ini? (Ya / Tidak) jika iya, mohon lampirkan"
                                                    , "a) Does your company have an SHE policy document that is applied in this region ? (Yes/No) if yes, please attach")
                                            ?>
                                            <?=
                                            areatext("2_1b", "", "b) siapa yang memiliki tanggung jawab keseluruhan dan terakhir untuk SHE di organisasi Anda?"
                                                    , "b) who has overall and final responsibility for SHE in your organization ?")
                                            ?>
                                            <?=
                                            areatext("2_1c", "", "c) Bagaimana Anda memastikan kepatuhan dan komunikasi kebijakan SHE di lokasi?"
                                                    , "c) How do you ensure SHE policy compliance and communication at site ?")
                                            ?>
                                            <!--2.2-->
                                            <label class="form-label"><?= lang("<strong>2.2. Ketersediaan Kebijakan Pernyataan kepada karyawan</strong>", "<strong>2.2. Availability of Policy Statements to employees</strong>")
                                            ?></label>
                                            <?=
                                            areatext("2_2", "", "Bagaimana Anda mengkomunikasikan kebijakan perusahaan Anda kepada karyawan Anda termasuk perubahan apa pun"
                                                    , "How do you communicate your company's policy to your employees including any changes")
                                            ?>
                                        </div>
                                    </fieldset>
                                    <fieldset id="bagian3" class="col-12">
                                        <h2 class="m-b"><?= lang("Organisasi, Sumber Daya, Standar dan Dokumentasi", "Organization,Resources,Standards and Documentation"); ?></h2>
                                        <div class="row">
                                            <!--3.1-->
                                            <label class="form-label"><?= lang("<strong>3.1. Organisasi - Komitmen dan Komunikasi</strong>", "<strong>3.1. Organization - Commitment and Communication</strong>")
                                            ?></label>
                                            <?=
                                            areatext("3_1a", "", "a) Bagaimana manajemen terlibat dalam kegiatan K3, penetapan dan pemantauan yang obyektif?"
                                                    , "a) How is management involved in SHE activities, objective setting and monitoring ?")
                                            ?>
                                            <?=
                                            areatext("3_1b", "", "b) Apa ketentuan yang dibuat perusahaan Anda untuk komunikasi dan pertemuan SHE?"
                                                    , "b) What provision does your company make for SHE communication and meetings ?")
                                            ?>
                                            <!--3.2-->
                                            <label class="form-label"><?= lang("<strong>3.2. Kompetensi dan Pelatihan Manajer / Staf Pengawas / Staf Senior / Penasihat SHE</strong>", "<strong>3.2. Competence and Training of Manager/Supervisors/Senior Site Staff/SHE Advisor</strong>")
                                            ?></label>
                                            <?=
                                            areatext("3_2", "", "Apakah manajer dan supervisor di semua tingkat yang akan merencanakan, memantau, mengawasi dan melaksanakan pekerjaan tersebut menerima pelatihan SHE formal dalam tanggung jawab mereka sehubungan dengan melakukan pekerjaan sesuai persyaratan SHE? (Ya/Tidak)"
                                                    , "Have the managers and supervisors at all levels that will plan, monitor, oversee and carry out the work received formal SHE training in their responsibilities with respect to conducting work to SHE requirements ? (Yes/No)")
                                            ?>
                                            <!--3.3-->
                                            <label class="form-label"><?= lang("<strong>3.3. Kompetensi dan Pelatihan SHE secara umum</strong>", "<strong>3.3. Competence and general SHE Training</strong>")
                                            ?></label>
                                            <?=
                                            areatext("3_3a", "", "a) Pengaturan apa yang telah dilakukan perusahaan Anda untuk memastikan karyawan memiliki pengetahuan tentang SHE industri dasar, dan agar pengetahuan terkini tetap terjaga?"
                                                    , "a) What arrangements has your company made to ensure employees have knowledge of basic industrial SHE, and to keep this knowledge up to date ?")
                                            ?>
                                            <?=
                                            areatext("3_3b", "", "b) Pengaturan apa yang telah dilakukan perusahaan Anda untuk memastikan SEMUA karyawan, termasuk sub kontraktor, juga memiliki pengetahuan tentang kebijakan dan praktik SHE?"
                                                    , "b) What arrangements has your company made to ensure ALL employees, including sub contractors, also have knowledge of yur SHE policies and practices ?")
                                            ?>
                                            <!--3.4-->
                                            <label class="form-label"><?= lang("<strong>3.4. Komite Manajemen SHE</strong>", "<strong>3.4. SHE Management Committee</strong>")
                                            ?></label>
                                            <?=
                                            areatext("3_4a", "", "Jelaskan secara singkat pengorganisasian Komite Manajemen SHE yang melibatkan Manajemen dan Karyawan Teratas di perusahaan Anda."
                                                    , "Explain briefly the organization of SHE Management Committee which involves Top Management and employees in your company.")
                                            ?>
                                            <!--3.5-->
                                            <label class="form-label"><?= lang("<strong>3.5. Pelatihan Khusus</strong>", "<strong>3.5. Specialized Training</strong>") ?></label>
                                            <?=
                                            areatext("3_5a", "", "Sudahkah Anda mengidentifikasi area operasi perusahaan Anda dimana pelatihan khusus diperlukan untuk mengatasi potensi bahaya? (Ya/Tidak)"
                                                    , "Have you identified areas of your company's operations where specialized training is required to deal with potential hazards ? (Yes/No)")
                                            ?>
                                            <?=
                                            areatext("3_5b", "", "Jika Ya, berikan daftar (misalnya radioaktif, asbes, peledak, menyelam, dll.)"
                                                    , "If Yes, please provide the list (e.g. radioactive, asbestos, explosive, diving, etc.)")
                                            ?>
                                            <!--3.6-->
                                            <label class="form-label"><?= lang("<strong>3.6. Staf Berkualitas SHE - Pelatihan Tambahan</strong>", "<strong>3.6. SHE Qualified Staff - Additional Training</strong>") ?></label>
                                            <?=
                                            areatext("3_6a", "", "Apakah perusahaan Anda memiliki spesialis SHE (terkait dengan layanan perusahaan Anda) yang dapat memberikan pelatihan untuk karyawan lain? (Ya/Tidak)"
                                                    , "Does your company have SHE specialists (related to your company's services) who can provide training for other employees ? (Yes/No)")
                                            ?>
                                            <?=
                                            areatext("3_6b", "", "Jika iya, mohon lampirkan cv."
                                                    , "If Yes, please attach the curriculum vitae.")
                                            ?>
                                            <!--3.7-->
                                            <label class="form-label"><?= lang("<strong>3.7. Penilaian Kesesuaian Subkontraktor</strong>", "<strong>3.7. Assessment of Suitability of Subcontractors</strong>")
                                            ?></label>
                                            <?=
                                            areatext("3_7a", "", "a) Bagaimana Anda menilai subkontraktor Anda untuk memastikan kepatuhan terhadap Kebijakan dan standar SHE perusahaan Anda, jika ada?"
                                                    , "a) How do you assess your sub-contractor(s) to ensure they comply with your company's SHE Policy and standards, if any ?")
                                            ?>
                                            <?=
                                            areatext("3_7b", "", "b) Apakah Anda mempekerjakan subkontraktor untuk layanan yang dimaksud? (Ya/Tidak)"
                                                    , "b) Do you employ sub-contractor(s) for the intended service ? (Yes/No)")
                                            ?>
                                            <!--3.8-->
                                            <label class="form-label"><?= lang("<strong>3.8. Standar</strong>", "<strong>3.8. Standards</strong>") ?></label>
                                            <?=
                                            areatext("3_8a", "", "a) Standar peraturan atau industri SHE apa yang perusahaan Anda lihat untuk layanan yang dimaksud?"
                                                    , "a) What kind of SHE regulatory or industrial standards that your company refer to for the intended service ?")
                                            ?>
                                            <?=
                                            areatext("3_8b", "", "b) Bagaimana Anda memastikan ini dipenuhi dan diverifikasi?"
                                                    , "b) How do you ensure these are met and verified ?")
                                            ?>
                                        </div>
                                    </fieldset>
                                    <fieldset id="bagian4" class="col-12">
                                        <h2 class="m-b"><?= lang("Resiko dan Manajemen Akibat", "Hazards and Effect Management"); ?></h2>
                                        <div class="row">
                                            <!--4.1-->
                                            <label class="form-label"><?= lang("<strong>4.1. Resiko dan Manajemen Akibat</strong>", "<strong>4.1. Hazards and effect management</strong>") ?></label>
                                            <?=
                                            areatext("4_1", "", "Apakah perusahaan Anda memiliki prosedur untuk identifikasi, penilaian, pengendalian dan mitigasi bahaya dan dampak? (Ya Tidak)"
                                                    , "Does your company have procedure for identification, assessment, control and mitigation of hazards and effects ? (Yes/No)")
                                            ?>
                                            <!--4.2-->
                                            <label class="form-label"><?= lang("<strong>4.2. Paparan Tenaga Kerja</strong>", "<strong>4.2. Exposure of the Workforce</strong>") ?></label>
                                            <?=
                                            areatext("4_2", "", "Sistem apa yang ada untuk memantau paparan bahaya terhadap tenaga kerja Anda misalnya agen kimia atau fisik?"
                                                    , "What systems are in place to monitor the hazard's exposure of your workforce e.g. chemical or physical agents ?")
                                            ?>
                                            <!--4.3-->
                                            <label class="form-label"><?= lang("<strong>4.3. Penanganan Material Yang Berpotensi Bahaya</strong>", "<strong>4.3. Handling of Potential Hazards</strong>") ?></label>
                                            <?=
                                            areatext("4_3", "", "Bagaimana tenaga kerja Anda memberi saran tentang potensi bahaya, berikan contoh."
                                                    , "How is your workforce advised on potential hazards eg. chemical, noise, radiation, etc. encountered in the course of their work ?")
                                            ?>
                                            <!--4.4-->
                                            <label class="form-label"><?= lang("<strong>4.4. Alat pelindung diri</strong>", "<strong>4.4. Personnel Protective Equipment</strong>")
                                            ?></label>
                                            <?=
                                            areatext("4_4a", "", "a) pengaturan apa yang dimiliki perusahaan Anda untuk penyediaan dan pembungkaman peralatan dan pakaian pelindung, baik standar dan yang diperlukan untuk kegiatan khusus?"
                                                    , "a) what arrangements does your company have for provision and unkeep of protective equipment and clothing, both standards issue, and that "
                                                    . "required for specialized activities ?")
                                            ?>
                                            <?=
                                            areatext("4_4b1", "", "b) Apakah Anda menyediakan perlengkapan pelindung diri yang layak (PPE) untuk karyawan Anda? (Ya/Tidak)"
                                                    , "b) Do you provide appropriate personnel protective equipment (PPE) for your employees ? (Yes/No)")
                                            ?>
                                            <?=
                                            areatext("4_4b2", "", "mohon cantumkan daftar PPE untuk lingkup pekerjaan ini"
                                                    , "  please provide a listing of the PPE for the scope of this work")
                                            ?>
                                            <?=
                                            areatext("4_c1", "", "c) Apakah Anda memberikan pelatihan bagaimana menggunakan PPE? (Ya Tidak)"
                                                    , "c) Do you provide training on how to use PPE ? (Yes/No)")
                                            ?>
                                            <?=
                                            areatext("4_c2", "", "Jelaskan isi pelatihan dan tindak lanjutnya"
                                                    , "  Explain the content of the training and any follow-up")
                                            ?>
                                            <?=
                                            areatext("4_d1", "", "d) Apakah Anda memiliki sebuah program untuk memastikan bahwa PPE terkena dampak dan dipelihara?"
                                                    , "d) Do you have a program to ensure that PPE is impacted and maintained ?")
                                            ?>
                                            <label class="form-label"><?= lang("<strong>4.5. Penanganan limbah</strong>", "<strong>4.5. Waste management</strong>")
                                            ?></label>
                                            <?= areatext("4_5a", "", "a) Sistem apa yang ada untuk identifikasi, klasifikasi, minimisasi dan pengelolaan wates?", "a) What systems are in place for identification, classification, minimization and management of wates ?")
                                            ?>
                                            <?=
                                            areatext("4_5b", "", "b) Mohon berikan jumlah kecelakaan yang mengakibatkan kerusakan lingkungan sebesar lebih dari "
                                                    . "USD 50.000 selama 24 bulan terakhir. Lampirkan salinan dari setiap laporan pemerintah yang disampaikan.", "b) Please provide the number of accidents resulting in environmental damage in the amount greater than USD 50,000 for the last 24 months. Attach copies of any"
                                                    . " governmental reports submitted.")
                                            ?>
                                            <?= areatext("4_5c", "", "Apakah anda memiliki prosedur untuk pembuangan limbah (Ya/Tidak)", "c) Do you have procedures for waste disposal (Yes/No)")
                                            ?>
                                            <?= areatext("4_5d", "", "e) Apakah Anda memiliki prosedur untuk pelaporan tumpahan? (Ya Tidak)", "d) Do you have procedures for spill reporting ? (Yes/No)")
                                            ?>
                                            <?= areatext("4_5e", "", "e) Apakah Anda memiliki prosedur untuk pembersihan tumpahan? (Ya Tidak)", "e) Do you have procedures for spill clean up ? (Yes/No)")
                                            ?>
                                            <?= areatext("4_5f", "", "f) Tolong berikan rincian peralatan Anda yang berkaitan dengan masalah lingkungan", "f) Please provide details at any of your equipment related to environmental matters")
                                            ?>
                                            <label class="form-label"><?= lang("<strong>4.7. Kebersihan Industri</strong>", "<strong>4.6. Industrial Hygiene</strong>") ?></label>
                                            <?=
                                            areatext("4_6a", "", "a) Apakah Anda memiliki program kebersihan industri? (Ya Tidak)"
                                                    , "a) Do you have an industrial hygiene program ? (Yes/No)")
                                            ?>
                                            <?=
                                            areatext("4_6b", "", "Mohon jelaskan proses ini. Jika ya, berikan daftar"
                                                    , "  Please describe this process. If yes, please provide the list.")
                                            ?>
                                            <label class="form-label"><?= lang("<strong>4.8. Alkohol dan Narkoba</strong>", "<strong>4.7. Drugs and Alcohol</strong>") ?></label>
                                            <?=
                                            areatext("4_7", "", "Apakah Anda memiliki kebijakan narkoba dan alkohol di organisasi Anda? (Ya / Tidak) Jika iya, mohon lampirkan"
                                                    , "Do you have a drugs and alcohol policy in your organization ? (Yes/No) If yes, please attach")
                                            ?>
                                        </div>
                                    </fieldset>
                                    <!-- 5.1 -->
                                    <fieldset id="bagian5" class="col-12">
                                        <h2 class="m-b"><?= lang("Prosedur dan Perencanaan", "Planning and Procedures"); ?></h2>
                                        <div class="row">
                                            <label class="form-label"><?= lang("<strong>5.1. SHE atau Operasi Manual</strong>", "<strong>5.1. SHE or Operations Manuals</strong>")
                                            ?></label>
                                            <?= areatext("5_1a", "", "a) Apakah Anda memiliki manual prosedur SHE? (Ya / Tidak) jika Ya, mohon lampirkan daftar isi", "a) Do you have SHE procedures manuals ? (Yes/No) if Yes, please attach the list of content")
                                            ?>
                                            <?=
                                            areatext("5_1b", "", "b) Bagaimana Anda memastikan bahwa prosedur kerja yang digunakan oleh karyawan Anda di tempat secara konsisten sesuai dengan tujuan dan pengaturan "
                                                    . "kebijakan SHE Anda?", "b) How do you ensure that the working procedures used by your employees on-site are consistently in accordance with your SHE policy objectives and arrangements ?")
                                            ?>
                                            <label class="form-label"><?= lang("<strong>5.2. Kontrol dan Pemeliharaan Peralatan</strong>", "<strong>5.2. Equipment Control and Maintenance</strong>") ?></label>
                                            <?=
                                            areatext("5_2", "", "Bagaimana Anda memastikan bahwa pabrik dan peralatan yang digunakan di tempat Anda, di tempat, atau di lokasi lain oleh karyawan Anda "
                                                    . "terdaftar dengan benar, disertifikasi dengan persyaratan peraturan, diperiksa, dikendalikan dan dipelihara dalam kondisi kerja yang aman?", "How do you ensure that plant and "
                                                    . "equipment used within your premises, on-site, or at other locations by your employees are correctly"
                                                    . " registered, certified with regulatory requirement, inspected, controlled and maintained in a safe working condition ?")
                                            ?>
                                            <label class="form-label"><?= lang("<strong>5.3 Manajemen dan Pemeliharaan Keselamatan Transportasi</strong>", "<strong>5.3 Transport Safety management and Maintenance</strong>") ?></label>
                                            <?= areatext("5_3", "", "Pengaturan apa yang dimiliki perusahaan Anda untuk pencegahan insiden kendaraan?", "What arrangement does your company have for vehicle incidents prevention ?")
                                            ?>
                                        </div>
                                    </fieldset>
                                    <!-- 5.2 -->
                                    <fieldset id="bagian6" class="col-12">
                                        <h2 class="m-b"><?= lang("Pengawasan Performa dan Pengerjaan", "Implementation and Performance Monitoring"); ?></h2>
                                        <div class="row">
                                            <label class="form-label">
                                                <?= lang("<strong>6.1. Manajemen K3 dan Pemantauan Kinerja Kegiatan Kerja</strong>", "<strong>6.1. SHE Management and Performance Monitoring of Work Acivities</strong>")
                                                ?></label>?>
                                            <?= areatext("6_1a", "", "a) Pengaturan apa yang dimiliki perusahaan Anda untuk pengawasan dan pemantauan kinerja SHE?", "a) What arrangement(s) does your company have for supervision and monitoring of SHE performance ?")
                                            ?>
                                            <?= areatext("6_1b", "", "b) Pengaturan apa yang dimiliki perusahaan Anda untuk diteruskan?", "b) What arrangements does your company have for passing on ")
                                            ?>
                                            <?= areatext("6_1b1", "", "(i) Manajemen Dasar", "(i) Base Management") ?>
                                            <?= areatext("6_1b2", "", "(ii) Karyawan lapangan", "(ii) Site employees") ?>
                                            <?= areatext("6_1c", "", "c) Apakah perusahaan Anda menerima penghargaan atas prestasi kinerja SHE? (Ya Tidak)", "c) Has your company received any award for SHE performance acheivement ? (Yes/No)")
                                            ?>
                                            <!--6.2-->
                                            <label class="form-label"><?= lang("<strong>6.2 Insiden Wajib Pajak / Kejadian Berbahaya, Persyaratan Perbaikan dan Pemberitahuan Larangan</strong>", "<strong>6.2 Statutory Notifiable Incidents/Dangerous occurences, Improvement Requirement and Prohibition Notices</strong>")
                                            ?></label>
                                            <?=
                                            areatext("6_2a", "", "Apakah perusahaan Anda mengalami persyaratan perbaikan atau pemberitahuan larangan atas insiden yang dapat dikenai undang-undang / "
                                                    . "kejadian berbahaya oleh badan nasional yang relevan, badan pengatur untuk SHE atau otoritas penegakan lainnya atau telah diadili berdasarkan undang-undang SHE dalam lima tahun terakhir?", "Has your company suffered any improvement requirement or prohibition notices on statutory notifiable incidents/dangerous occurences by the "
                                                    . "relevant national body, regulatory body for SHE or other enforcing authority or been prosecuted under any SHE legislation in the last five years ?")
                                            ?>
                                            <?= areatext("6_2b", "", "Jika iya, tolong beri jumlah kejadian dan deskripsi singkatnya", "If yes, please give the number of occurences and its short description")
                                            ?>
                                            <!--6.3-->
                                            <label class="form-label"><?= lang("<strong>6.3. Catatan Kinerja SHE</strong>", "<strong>6.3. SHE Performance Records</strong>")
                                            ?></label>
                                            <label class="form-label"><?=
                                                lang("<strong>a) Tolong berikan rincian statistik kinerja SHE Anda selama 3 tahun terakhir (jika tidak dicatat / berlaku, tandai N / R atau N / A)</strong>"
                                                        , "<strong>a) Please provide statistical details of your SHE performance over the past 3 years (if not recorded/applicable please mark N/R or N/A)</strong>")
                                                ?></label>
                                            <table class="table display">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th><?= lang("Total<br/>(Termasuk semua kontrak dan sub kontrak pegawai)", "Total Number</br>(incl. All contracts & sub contract personnel)") ?></th>
                                                        <th><?= lang("Frekuensi", "Frequency") ?><br/><?= lang("Berdasarkan OSHA", "(based on OSHA)") ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?= lang("Fatalities", "Fatalities") ?></td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="6_3a1" name="6_3a1">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="6_3a2" name="6_3a2">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= lang("Day away from work cases (DAFWC) or LTIs", "Fatalities") ?></td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="6_3a3" name="6_3a3">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="6_3a4" name="6_3a4">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= lang("Total recordable cases", "Fatalities") ?></td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="6_3a5" name="6_3a5">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="6_3a6" name="6_3a6">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <?= areatext("6_3b", "", "c) Bagaimana kinerja  kesehatan yang telah tercatat?"
                                                    , "b) How is health performance recorded ?")
                                            ?>
<?= areatext("6_3c", "", "c) Bagaimana kinerja lingkungan yang telah tercatat?"
        , "c) How is environmental performance recorded ?")
?>
                                            <!--6.4-->
                                            <label class="form-label"><?= lang("<strong>6.4. Investigasi dan Pelaporan Insiden</strong>", "<strong>6.4. Incident Investigation and Reporting</strong>")
?></label>
                                            <?= areatext("6_4a", "", "a) Apakah Anda memiliki prosedur untuk penyelidikan, pelaporan dan tindak lanjut dari kecelakaan, kejadian berbahaya atau penyakit akibat kerja? (Ya / Tidak) jika iya, mohon lampirkan", "a) Do you have a procedure for investigation, reporting and follow-up of accidents, dangerous occurences or occupational illness ? (Yes/No) if yes, please attach")
                                            ?>
                                            <?= areatext("6_4b", "", "b) Bagaimana temuan setelah penyelidikan, atau insiden terkait yang terjadi di tempat lain, dikomunikasikan kepada karyawan Anda?", "b) How are the findings following an investigation, or relevant incident occurring elsewhere, communicated to your employees ?")
                                            ?>
<?= areatext("6_4c", "", "Harap lampirkan contoh laporan investigasi selama 12 bulan terakhir.", "Please attach an example of investigation reports during the last 12 months.")
?>
                                        </div>
                                    </fieldset>

                                    <fieldset id="bagian7" class="col-12">
                                        <h2 class="m-b"><?= lang("Audit dan Tinjauan", "Audit and Review"); ?></h2>
                                        <div class="row">
                                            <label class="form-label"><?= lang("<strong>a) Apakah Anda memiliki kebijakan tertulis tentang audit SHE? (Ya/Tidak)</strong>", "<strong>a) Do you have a written policy on SHE auditing ? (Yes/No)</strong>")
?></label>
                                            <?= areatext("7_a", "", "", "") ?>
                                            <label class="form-label"><?= lang("<strong>b) Bagaimana kebijakan ini menetapkan standar audit, termasuk jadwal, cakupan dan kualifikasi auditor?</strong>", "<strong>b) How does this policy specify the standards for auditing, including schedule, coverage and the qualification for auditors ?</strong>")
                                            ?></label>
                                            <?= areatext("7_b", "", "", "") ?>
                                            <label class="form-label"><?= lang("<strong>c) Bagaimana efektivitas audit diverifikasi dan bagaimana caranya?</strong>", "<strong>c) How is the effectiveness of auditing verified and how does </strong>")
                                            ?></label>
<?= areatext("7_c", "", "", "") ?>
                                        </div>
                                    </fieldset>
                                    <fieldset id="bagian8" class="col-12">
                                        <h2 class="m-b"><?= lang("Prosedur Respon Keadaan Darurat  ", "Emergency Response Procedure"); ?></h2>
                                        <div class="row">
                                            <label class="form-label"><?= lang("<strong>Apakah Anda memiliki rencana tanggap darurat? (Ya / Tidak), jika ya, silahkan melampirkan</strong>", "<strong>Do you have an emergency response plan ? (Yes/No), if yes, please attach</strong>")
?></label>
<?= areatext("8_a", "", "", "") ?>
                                        </div>
                                    </fieldset>

                                    <fieldset id="bagian9" class="col-12">
                                        <h2 class="m-b"><?= lang("Bagian 9 - Manajemen SHE", "Section - 9 SHE Management - Additional Features"); ?></h2>
                                        <div class="row">
                                            <label class="form-label"><?= lang("<strong>a) Apakah perusahaan anda memegang keanggotaan asosiasi? (Ya Tidak)</strong>", "<strong>a) Do you company hold association(s) membership ? (Yes/No)</strong>")
?></label>
                                            <?= areatext("9_a", "", "", "") ?>
                                            <label class="form-label"><?= lang("<strong>Jika ya, tuliskan daftarnya</strong>", "<strong>If yes, please provide the list</strong>")
                                            ?></label>
                                                <?= areatext("9_a1", "", "", "") ?>
                                            <label class="form-label"><?=
                                            lang("<strong>b) Apakah ada aspek kinerja SHE Anda yang Anda percaya membedakan Anda dari pesaing Anda yang tidak dijelaskan di
                                    tempat lain dalam tanggapan Anda terhadap kuesioner? Jika ya, tolong jelaskan</strong>", "<strong>b) Are there any aspect of your SHE performance that you believe differentiates you from your competitors that not described elsewhere in your "
                                                    . "response to the questionnaire ? If yes, please explain</strong>")
                                            ?></label>
<?= areatext("9b", "", "", "") ?>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <div class="text-center" style="margin-top: 120px">
                                            <h2 class="m-b"><?= lang("Terima Kasih", "Thank You") ?></h2>
                                            <div class="form-group">
                                                <h4><?= lang("Klik Tombol Finish untuk menyimpan data", "Click Finish button to save the data") ?></h4>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                                <hr/>
                                <div class="pull-right">
                                    <button class="btn btn-outline-primary add_attch" onclick="tambah()"><i class="ft-plus-circle"></i>Tambah Data</button>
                                </div>
                                <div class="mb-1"></div>
                                <table id="csms_table" class="table table-striped table-bordered table-hover display" width="100%" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php
            $this->load->view('V_side_menu', $menu);
        ?>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah data Lampiran", "Add Attachment Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body col-12 CSMS">
                <form id="company_csms" class="form" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-4 control-label" for="">
                                <?= lang("Jenis File", "File Type"); ?>
                            </label>
                            <div class="col-8">
                                <input type="hidden" class="form-control" id="id_csms" name="id_csms">
                                <input type="text" class="form-control" id="jenis_csms" name="jenis_csms">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="">
                                <?= lang("Keterangan", "Description"); ?>
                            </label>
                            <div class="col-12">
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-6 control-label" for="">
                                <?= lang("File Lampiran", "File Attachment"); ?>
                            </label>
                            <div class="col-12">
                                <input type="file" name="file_csms" id="file_csms" class="form-control">
                            </div>
                            <div id="upload" class="col-12">
                                <p><?=lang("Data Telah terupload","Data has been upload")?></p>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <div class=" col-12 text-right">
                                <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                                <button type="submit" style="width:115px" name="update_keys" id="update_keys" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                                <button type="submit" style="width:115px" id="add" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Tambah data", "Add Data") ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal_file" class="modal fade bs-example-modal-lg" role="dialog" style="z-index: 9999;"  >
    <div class="modal-dialog modal-xl">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title">Preview File</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <iframe
                    id="ref"
                    style="width:100%; height:600px;" frameborder="0">
                </iframe>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function ()
    {
        var index = 0;
        $.ajax({
            url: "<?= base_url('vn/info/csms/get_data') ?>",
            type: "POST",
            cache: "false",
            success: function (res)
            {
                if (res != null) {
                    var len = Object.keys(res).length;
                    for (var i = 0; i < 9; i++)
                    {
                        var elmn1 = $("#form-p-" + i + " :input");
                        for (var j = 0; j < elmn1.length; j++)
                        {
                            if (res[elmn1[j].id] != '')
                            {
                                index = i;
                            }
                            $("#form-p-" + i + " #" + elmn1[j].id).text(res[elmn1[j].id]);
                        }
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown)
            {
                msg_danger("Gagal", "Oops,Terjadi kesalahan pengambilan data");
            }
        });

        $.ajax({
            url: "<?= base_url('vn/info/csms/check_status') ?>",
            type: "POST",
            cache: "false",
            success: function (res)
            {
                if(res != null && res[0].RISK == '0'){
                  $('#form :input').attr('disabled',true);
                  $('.add_attch').attr('disabled',true);
                  // $('a').attr('disabled',true);
                } else {
                  $('#form :input').attr('disabled',false);
                  $('.add_attch').attr('disabled',false);
                  // $('a').attr('disabled',false);
                }
            },
        });

        var tabel = $('#csms_table').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/csms/show') ?>',
                'dataSrc': ''
            },
            scrollX: true,
            scrollY: "300px",
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title:"NO"},
                {title:"<?=lang("Jenis File"," File Type")?>"},
                {title:"<?=lang("Keterangan"," Description")?>"},
                {title:"<?=lang("File","File")?>"},
                {title:"<?=lang("&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp","&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp")?>"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
            ]
        });
         $('#csms_table tbody').on('click', 'tr .update-csms', function () {
            var data2 = tabel.row($(this).parents('tr')).data();
            console.log(data2);
            $('#company_csms #jenis_csms').val(data2[1]);
            $('#company_csms #description').val(data2[2]);
            $('#modal #add').hide();
            $('#upload').show();
            $('#modal #update_keys').show();
            $('#modal #update_keys').val(this.id);
            $('#modal #id_csms').val(this.id);
            $('#modal .modal-title').html("<?= lang("Perbarui Data Lampiran", "Update Attachment Data") ?>");
            lang();
            $('#modal').modal('show');
        });

        lang();
        var form = $(".steps-validation").show();
        $(".number-tab-steps").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: 'Submit'
            },
            onFinished: function (event, currentIndex) {
                alert("Form submitted.");
            }
        });

        $(".steps-validation").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: 'Submit'
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                // Forbid next action on "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age-2").val()) < 18)
                {
                    return false;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                var tamp = form.valid();
                if (tamp != false)
                {
                    if (currentIndex == 0) {
                        var obj = $('#form-p-0 :input').serializeArray();
                        msg_default("INFO", "Data dalam proses upload")
                        obj[obj.length] = {name: "update", value: false};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 1) {
                        var obj = $('#form-p-1 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 2) {
                        var obj = $('#form-p-2 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 3) {
                        var obj = $('#form-p-3 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 4) {
                        var obj = $('#form-p-4 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 5) {
                        var obj = $('#form-p-5 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 6) {
                        var obj = $('#form-p-6 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 7) {
                        var obj = $('#form-p-7 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                    else if (currentIndex == 8) {
                        var obj = $('#form-p-8 :input').serializeArray();
                        obj[obj.length] = {name: "update", value: true};
                        console.log(obj);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                            cache: false,
                            data: obj,
                            success: function (res)
                            {
                                msg_info("Success", "Data berhasil disimpan");
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                            }
                        });
                    }
                }
                return tamp;
            },
            onFinishing: function (event, currentIndex)
            {

                var form = $(this);
                form.validate().settings.ignore = ":disabled";
                var valid = form.valid();
                if (valid) {
                    var obj = {};
                    obj = {"update": "finish"};
                    console.log(obj);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('vn/info/csms/save_data') ?>",
                        cache: false,
                        data: obj,
                        success: function (res)
                        {
                            msg_info("Success", "Data berhasil disimpan");
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            msg_danger("Gagal", "Oops,Terjadi kesalahan");
                        }
                    });
                }
                return valid;
            },
            onFinished: function (event, currentIndex)
            {
                alert("Submitted!");
            }
        });

// Initialize validation
        $(".steps-validation").validate({
            ignore: 'input[type=hidden]', // ignore hidden fields
            errorClass: 'danger',
            successClass: 'success',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            rules: {
                email: {
                    email: true
                }
            }
        });
        $('#company_csms').validate({
            focusInvalid: false,
            rules: {
                jenis_csms: {required: true, maxlength: 60},
                description: {required: true, maxlength: 500},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "pengesahan") && (elmnt !== "tanggal_akta") && (elmnt !== "berita"))
                    $('<span class="error"></span>').insertAfter(element).append(label)
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            highlight: function (element) { // hightlight error inputs
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            success: function (label, element) {
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-error').addClass('has-success');
                label.parent().removeClass('error');
                label.remove();
            },
            submitHandler: function (form)
            {
                var elm=start($('#modal').find('.modal-content'));
                var formData = new FormData($('#company_csms')[0]);
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/csms/add_attch'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status === "Sukses")
                        {
                            msg_info(res.status, res.msg);
                            document.getElementById("company_csms").reset();
                             $("#csms_table").DataTable().ajax.reload();
                            $('#update_keys').val("0");
                            $('#modal').modal('hide');
                        }
                        else
                            msg_danger(res.status, res.msg);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    }
                });
            }
        });
    });
    function review(data)
    {
        $('#ref').attr('src', data);
        $('#modal_file').modal('show');
    }
    function tambah()
    {
        $('#modal #id_csms').val("");
        $('#modal .modal-title').html("<?= lang("Tambah data Lampiran", "Add Attachment Data") ?>");
        $('#add').show();
        $('#update_keys').hide();
        $('#upload').hide();
        lang();
        $('#modal .modal-title').html("<?= lang("Tambah Data Lampiran", "Add Attachment Data") ?>");
        $('#modal').modal('show');
    }
    function delete_attach(id)
    {
        var data = {};
        data.ID = id;
        data.API = "delete";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/all_vendor/check_vendor'); ?>",
            cache: false,
            success: function (res)
            {
                if (res == true)
                {
                    msg_danger("Error", "Data tidak diperbolehkan untuk diubah");
                    return;
                }
                else
                    delete_data(data, "delete_attch", "#csms_table");
            }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                swal("Data Gagal di hapus", "", "failed");
            }
        });
    }
    function delete_data(obj, dt, tbl)
    {
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data ini",
            type: "warning",
            showCancelButton: true,
            CancelButtonColor: "#DD6B55",
            confirmButtonColor: "#d9534f",
            confirmButtonText: "Ya, hapus",
            closeOnConfirm: false
        }, function () {
            msg_default('Proses', "Data Sedang dihapus");
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/csms/') ?>" + dt,
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        $(tbl).DataTable().ajax.reload();
                        $(tbl).DataTable().columns.adjust().draw();
                        msg_info("Success", "Data Berhasil Dihapus");
                        swal("Data Berhasil dihapus", "", "success");
                    } else {
                        swal("Data Gagal dihapus", "", "failed");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                }
            });
        });
    }
</script>
