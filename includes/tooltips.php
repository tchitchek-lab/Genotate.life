<?php
$tooltip_text = array();
$tooltip_text ['dataset_filter'] = "Select here the dataset you are interested in (more details about the annotation datasets are available in the 'manage annotations' interface)";
$tooltip_text ['keyword_filter'] = "Provide here some annotation filtering criteria (algorithm name, minimal and maximal number of annotations)";
$tooltip_text ['start_codon'] = "codon(s) used to define the begin of an ORF";
$tooltip_text ['stop_codon'] = "codon(s) used to define the end of an ORF";
$tooltip_text ['orf_min_size'] = "keep only ORFs with a length higher than a specific threshold";

$tooltip_text ['checkORF'] = "keep only ORFs with a CPAT coding potential higher than a specific threshold";

$tooltip_text ['coding_only_filter'] = "filter to display only conding transcripts";
$tooltip_text ['noncoding_only_filter'] = "filter to display only non-coding transcripts";
$tooltip_text ['annotated_only_filter'] = "filter to display only annotated transcripts";

$tooltip_text ['inner'] = "an inner ORF is an ORF contained in larger ORF";
$tooltip_text ['outside'] = "an outside ORF lacks either the start or stop codon";
$tooltip_text ['compute_ncRNA'] = "keep transcripts without ORF (such as ncRNA)";
$tooltip_text ['compute_both_strands'] = "search annotations also on the reverse transcript sequences";
$tooltip_text ['glycosylation'] = "annotate the amino acid which may carry glycosylation";
$tooltip_text ['epitopes'] = "annotate binding site to specific MHC class I&II, and B-cell";
$tooltip_text ['protein_family'] = "annotate functional domains in protein family databases";
$tooltip_text ['structure'] = "annotate transmembrane domains and disordered domains";
$tooltip_text ['signal_peptide'] = "annotate the secretory signal peptide, a ubiquitous signal that targets for translocation across the membrane";
$tooltip_text ['propeptide'] = "annotate arginine and lysine propeptide cleavage sites, which characterize inactive peptides precursors";
$tooltip_text ['orf_panel'] = "Define the parameters used for identification of ORFs and associated proteins";
$tooltip_text ['functional_panel'] = "Define here the algorithms to use for the identification of structural annotations";
$tooltip_text ['similarity_panel'] = "Define here the databases to use for the identification of homology annotations";
$tooltip_text ['transcript_panel'] = "Provide here the transcript sequence to annotate with optional parameters";
$tooltip_text ['transcripts_panel'] = "select your file with fasta formatted nucleic sequence for the transcript you which to annotate";
$tooltip_text ['username'] = "please enter here your username";
$tooltip_text ['password'] = "please enter here your password";
$tooltip_text ['email'] = "provide an email to be notified when the annotation results are available";
$tooltip_text ['annotation_description'] = "provide additional information about the annotation analysis";
$tooltip_text ['annotation_name'] = "provide an optional name to your analysis";
$tooltip_text ['manage_annotations'] = "List the available annotation result datasets with their associated information";
$tooltip_text ['manage_download_transcripts'] = "download transcripts associated with this annotation result dataset";
$tooltip_text ['manage_download_regions'] = "download regions (ORFs and ncRNAs) associated with this annotation result dataset";
$tooltip_text ['manage_download_proteins'] = "download proteins associated with this annotation result dataset";
$tooltip_text ['manage_download_annotation'] = "download annotations associated with this dataset";
$tooltip_text ['manage_references'] = "List the available reference homology datasets with their associated information";
$tooltip_text ['annotation_colors'] = "Define here the colors used for each annotation in the annotation viewer";
$tooltip_text ['database_configuration'] = "Define here the Genotate database and login information";

$tooltip_text ['annotated_only'] = "select only transcripts having at least one annotation";

$tooltip_text ['create_reference'] = "Homology references can be created using either nucleic or proteomic sequences";
$tooltip_text ['reference_file'] = "provide a fasta file containing transcriptomic or proteomic sequences";
$tooltip_text ['reference_ftp'] = "provide an ftp link to a fasta file containing transcriptomic or proteomic sequences";
$tooltip_text ['reference_name'] = "provide the name of the homology reference";
$tooltip_text ['reference_email'] = "provide an email to be notified when the homology reference is created";
$tooltip_text ['reference_species'] = "describe the species of the homology reference";
$tooltip_text ['reference_release'] = "describe the release version of the homology reference";
$tooltip_text ['reference_description'] = "provide additional information about the homology reference";

$tooltip_text ['identified_elements'] = "Provide an overview of the available sequences and identified annotations";


$tooltip_text ['ftp_example'] = "datasets available by ftp";
$tooltip_text ['manage_services'] = "Show the available Genotate annotations services";
$tooltip_text ['genotateweb_parameters'] = "Define here the Genotate parallel parmeters";
$tooltip_text ['genotateweb_config'] = "Please refer to Genotate Web github installation tutorial";
$tooltip_text ['genotate_config'] = "Please refer to Genotate github installation tutorial";

$tooltip_text ['NONCODE'] = "NONCODE is an annotation collection for non-coding RNAs, especially long non-coding RNAs (lncRNAs)";
$tooltip_text ['UNIREF'] = "UniRef databases provide full-scale clustering of UniProtKB sequences and are utilized for a broad range of applications, particularly similarity-based functional annotation";
$tooltip_text ['ENSEMBL'] = "Ensembl's provide a centralized resource for geneticists, molecular biologists and other researchers studying the genomes of vertebrates and model organisms. Ensembl is one of several well known genome browsers for the retrieval of genomic information.";

$tooltip_text ['dataset_info'] = "Provide informations on the transcript dataset and the computed annotations";
$tooltip_text ['transcript_sequence_input'] = "insert the nucleic sequence of the transcript you want to annotate (no more than 200,000 bases)";
$tooltip_text ['transcript_sequence_file'] = "select your file with fasta formatted nucleic sequence for the transcript you which to annotate";
$tooltip_text ['reference_details'] = "panel with the optional reference information set by the user";

$tooltip_text ['home_user_signin'] = "Login to access your private annotation datasets";
$tooltip_text ['home_user_signup'] = "Create an account to use private annotation datasets";
$tooltip_text ['home_user_account'] = "Access your personal information";
$tooltip_text ['home_user_forgot_password'] = "enter the email that you used for the registration";

$tooltip_text ['tt_home_annotate_single'] = "Identify homology and functional annotations for a given transcript sequence";
$tooltip_text ['tt_home_annotate_multiple'] = "Identify homology and functional annotations for a set of transcript sequences";
$tooltip_text ['tt_home_explore_results'] = "Explore and search annotated transcript sequences based on specific criteria";
$tooltip_text ['tt_home_manage_results'] = "Display the available public annotation result datasets";
$tooltip_text ['tt_home_tutorial'] = "Get some help about how to use Genotate";
$tooltip_text ['tt_home_about'] = "Get some information about Genotate and the developers";

$tooltip_text ['tt_home_admin_manage_results'] = "Display, edit or delete the available annotation result datasets";
$tooltip_text ['tt_home_admin_manage_references'] = "Display, edit or delete the available homology reference datasets";
$tooltip_text ['tt_home_admin_create_references'] = "Create your own homology reference datasets";
$tooltip_text ['tt_home_admin_import_references'] = "Import homology reference datasets from pubicly NONCODE, UniRef, and Ensembl databases";
$tooltip_text ['tt_home_admin_configure_database'] = "Configure the database login, which is used to store the datasets";
$tooltip_text ['tt_home_admin_configure_platform'] = "Configure the web platform dependencies";

$tooltip_text ['rrna'] = "identify ribosomal transcript";
$tooltip_text ['trna'] = "identify transfert transcript";

$tooltip_text ['manage_view'] = "explore the annotation result dataset";
$tooltip_text ['manage_explore'] = "explore the annotation result dataset";
$tooltip_text ['manage_getinfo'] = "get details about the annotation result dataset";
$tooltip_text ['genotateweb_space'] = "Display the available space in the Genotate server";
$tooltip_text ['example_sequence_1'] = "load the Human PPP1R1A phosphatase sequence as an example";
$tooltip_text ['example_sequence_2'] = "load the Human ATP7B ATPase sequence as an example";
$tooltip_text ['example_sequence_3'] = "load the Mouse Ayu17-449 oxygenase sequence as an example";
$tooltip_text ['code_standard'] = "load the standart genetic code";
$tooltip_text ['code_vert_mito'] = "load the Vertebrate Mitochondrial genetic code";
$tooltip_text ['code_invert_mito'] = "load the Invertebrate Mitochondrial genetic code";
$tooltip_text ['login_interface'] = "Use your login information to access your private datasets";
$tooltip_text ['reset_password'] = "Reset here your password";
$tooltip_text ['registration'] = "Please enter the following information to create your account";

$tooltip_text ['create_reference_proteic'] = "define the homology annotation as a transcriptomic reference";
$tooltip_text ['create_reference_nucleic'] = "define the homology annotation as a proteomic reference";
$tooltip_text ['create_reference_link'] = "provide your homology annotation reference as a link to fasta file";
$tooltip_text ['create_reference_file'] = "provide your homology annotation reference as a fasta file";

$tooltip_text ['register_username'] = "provide a username that you want to use";
$tooltip_text ['register_firstname'] = "provide your first name";
$tooltip_text ['register_lastname'] = "provide your last name";
$tooltip_text ['register_email'] = "provide your email";
$tooltip_text ['register_password'] = "provide a secured password";
$tooltip_text ['register_confirmpassword'] = "confirm a secured password";
$tooltip_text ['register_check'] = "please read the terms and conditions";


