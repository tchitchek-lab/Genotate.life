<link rel="stylesheet" type="text/css" href="/css/tutorial.css">

<script src="/js/tutorial.js" xmlns:right></script>

<?php $anchor_id = 0; ?>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Introduction
</div>
<div id="navbar-left"
     style='position: absolute; left: 0; display: none; width: 0; height: 100%; overflow-x: auto;margin-top:30px;'></div>


<div class="anchor div-border-subtitle" style='width: 100%;margin-top:20px' id='<?php echo $anchor_id++; ?>'>Overview
</div>
<div id="navbar-left"
     style='position: absolute; left: 0; display: none; width: 0; height: 100%; overflow-x: auto;margin-top:30px;'></div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The Genotate platform allows the automatic annotation of transcript sequences. Annotations can be predicted based on sequence homology and functional analyses at both the transcript and amino acid levels. Identified annotations can be easily visualized using interactive viewers. Furthermore, users can search for transcripts having specific features among their annotation results.
    <p>
        In this tutorial, the main functionalities of the Genotate transcript annotation platform are described, such as:<br></p>
    <ul>
        <li> the annotation of a single transcript sequence</li>
        <li> the annotation of a multiple transcript sequences</li>
        <li> the visualization of annotation results</li>
        <li> the exploration and identification of transcript sequences based on their identified annotations</li>
    </ul>

    <p>
        Additionally, several Genotate management functionalities are described, such as:<br></p>
    <ul>
        <li> the management of annotation results</li>
        <li> the management of homology references</li>
        <li> the configuration of the Genotate database</li>
        <li> the configuration of the Genotate parameters</li>
    </ul>


    <p>
        The algorithms, tools and databases used by Genotate are described at the end of this tutorial.
    </p>
</div>


<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Background
</div>
<div id="navbar-left"
     style='position: absolute; left: 0; display: none; width: 0; height: 100%; overflow-x: auto;margin-top:30px;'></div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>High-throughput technologies generate large quantities of complex high-dimensional biological data. These
        techniques are more and more precise and the acquisition costs are constantly decreasing. Especially,
        RNA-seq (NGS) can be used to characterize the transcriptome of new animal species or specific cell
        types.</p>
    <p>RNA-seq technologies generally produce fragments of transcriptomic sequences, named reads, which need to be
        assembled. Illumina is one of the most used RNA-seq techniques and can sequence reads up to hundreds of
        bases. The PacBio and the Nanopore techniques can sequence reads up to hundreds of kilo-bases. Reads are
        usually assembled into transcripts with different algorithms.</p>
    <p>Once assembled, transcripts must be annotated. Transcript annotations can be defined either at the homology or functional levels.
        Firstly, transcripts can be annotated based on their homology with transcriptomic annotated
        references. Secondly, proteins translated from transcript sequences can be annotated based on their
        homology with proteomic annotated references, and based on their peptidic domains.</p>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Genotate functionalities
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The Genotate web platform has been developed to allow non-bioinformaticians to automatically annotating their
        transcript sequences. Annotation results can be visualized and user can search for specific transcripts within their
        annotation results.</p>
    <p>The platform allows to upload transcripts, specify annotation options, predict the transcript annotations, visualize the
        identified transcript annotations, search for transcript having specific annotations, and to download the computed results. </p>
    <p>This platform also provides administrative interfaces to manage annotation results and homology references.
        Finally, the platform provides interfaces to configure the software dependencies and database parameters. </p>
    <img src="/img/functionalities.png?v=201" alt="/functionalities.png?v=201" style="width: 100%;">
    <label>Overview of the Genotate user interface</label>
    <img src="/img/admin.png?v=201" alt="/functionalities.png?v=201" style="width: 100%;">
    <label>Overview of the Genotate administration user interface</label>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Overview of the annotation
    workflow
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The Genotate annotation pipeline takes in input one fasta file containing a single transcript or multiple transcripts. 
	The annotation steps and options are defined using the web interface. 
	For each reconstructed transcript, Genotate first separate coding and non coding transcript.
	Coding transcript contain one or multiple encoding ORF.
	Genotate detects the set of all possible ORFs, the ORF with a protein coding potential over a defined threshold are translated for further annotation.
	The transcript without any protein coding ORF are further annotated as noncoding transcript.
	All transcript are annotated based on: 
	(i) their homology with other reference sequences, also named homology annotations; and 
	(ii) for coding transcript, the presence of peptidic functional elements on their resulting translated proteins, also named functional annotations. 
	Homology annotations are computed based on any reference dataset of nucleic, transcriptomic or proteomic sequences specified by users or available by default in Genotate. 
	The functional annotations are computed based on a compendium of publicly available computational tools and databases specified by the user.</p>

    <p>A large collection of annotation services and databases are available in Genotate. Indeed, reference transcriptomic and proteomic datasets from the NONCODE, UniRef, and Ensembl databases are available (consisting of more than 100 animal species). Additionally, multiple protein annotation software are available (consisting in around 30 different algorithms). Non-coding transcripts can also be analyzed with Genotate.</p>
        <img src="/img/workflow.png?v=201" alt="workflow.png?v=201" style="width: 100%;">
    <label>Overview of the Genotate annotation workflow</label>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Annotation of single or
    multplie transcripts
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Transcript annotation
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Transcripts can be annotated using the single or multiple transcript annotation interfaces. Sequences can be
        submitted as sequences or as fasta file. Sequences must not contain other characters than 'A', 'T', 'G', 'C', or
        'N'. Example sequences are available in the interface to annotate a single transcript. </p>
    <p>Each interface provides the different options to parametrize the ORF detection, homology, and functional
        analyses.</p>
    <img src="/img/single_transcript_annotation.png?v=201" alt="/single_transcript_annotation.png?v=201"
         style="width: 50%; margin-left: 25%">
    <label>Overview of the interface to annotate a single transcript </label>
    <img src="/img/multiple_transcripts_annotation.png?v=201" alt="/multiple_transcripts_annotation.png?v=201"
         style="width: 50%; margin-left: 25%">
    <label>Overview of the interface to annotate a multiple transcripts</label>

    <p></p>
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>ORF identification
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>For each transcript to analyze, Genotate first detects the sets of all possible ORFs based on parameters selected
        in the ORF panel. ORFs are then translated to obtain the associated protein sequences. The start and stop codons
        (which initiate and end the ORFs) can be specified by users. By default, start codon is set to 'ATG' and stop
        codons to 'TAG, TGA, and TAA'. ORFs with a length lower than a threshold can be filtered to avoid
        interpretations of sequences with no biological meaning. Inner ORFs (which consist of nested ORF sequences) can
        also be identified as well as outside ORF (which consist of ORFs lacking either the start or stop codon). 
		Each ORF is by default checked by CPAT to measure its coding potential. By
        default, the transcript without any coding ORF are annotated as a non-coding RNA. By default, ORFs are
        also identified on the reverse complemented transcript sequence.</p>
    <img src="/img/orf_identification_panel.png?v=201" alt="orf_identification_panel.png?v=201"
         style="width: 50%; margin-left: 25%">
    <label>Overview of the ORF detection panel</label>
    <p>In detail, the protein associated to a transcript are obtained by detecting all the possible ORF on the transcript. A frame is composed of nucleotide triplets called codon. The transcript sequence is divided into three frames, with a shift of one base on the sequence strand. The transcript sequence can also be reversed, and the nucleic base complemented to obtain the complementary sequence. An Open Reading Frame begins with a codon start and ends with a codon stop. A codon can be translated to an amino acid or end of translation signal. A codon encoding the beginning of the translation, such as 'ATG', is called codon start. A codon encoding the end of the translation, such as 'TAG, TGA, TAA', is called codon stop. A protein is obtained from the translated sequence of an Open Reading Frame.</p>
    <img src="/img/orf_identification.png?v=201" alt="orf_identification.png?v=201" style="width: 50%; margin-left: 25%">
    <label>ORF identification method</label>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Identification of homology
    annotations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Homology annotations are computed based on any reference dataset of transcriptomic or proteomic sequences specified by users or available by default in Genotate. </p>
    <img src="/img/references.png?v=201" alt="references.png?v=201" style="width: 100%;">
    <label>Overview of the possible homology references</label>
    <p>Sequences homologies are identified using the BLAST algorithm. Homology results can be filtered based on the percentage identity match, the percentage of query sequence coverage, and the percentage of reference sequence coverage.</p>
    <img src="/img/interface_references.png?v=201" alt="interface_references.png?v=201" style="width: 50%;">
	<img src="/img/references_scores.png?v=201" alt="references_scores.png?v=201" style="width: 50%;float:right">
    <label>Overview of the homology annotation panel</label>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Identification of
    functional annotations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Genotate can annotate transcripts based on the functional domains of their associated proteins based on multiples
        algorithm. These annotation algorithms can be
        selected in the functional annotation panel. For each algorithm, a threshold or e-value parameter is available to
        filter the annotation results.
    </p>
    <img src="/img/functional_annotation_panel.png?v=201" alt="/functional_annotation_panel.png?v=201"
         style="width: 50%; margin-left: 25%">
    <label>Overview of the homology annotation panel</label>
    <p>In details, the functional annotation are computed based on a large set of publicly available computational
        algorithms and
        databases. Especially, the InterproScan identify conserved functional domains on a protein, and unify multiple
        protein family databases and alignment algorithms. InterproScan unifies proteins functional domains from
        different databases such as PFAM, SUPERFAMILY, and PANTHER. </p>
    <p>The functional annotation are computed based on multiple other prediction algorithms, such as TMHMM,
        SIGNALP, and PROP.</p>
    <img src="/img/functional.png?v=201" alt="functional.png?v=201" style="width: 100%;">
    <label>Overview of the functional annotation algorithms</label>
    <p></p>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Visualization of annotation results
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Annotation results
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>A result interface is displayed when the annotation are computed. For each transcript, a panel
        represents the elements identified on the transcript. Moreover, a result summary panel provides the number of
        ORFs identifies, the number of identified annotations, and allows to download the associated sequences.
        </p>
    <img src="/img/annotation_results.png?v=201" alt="annotation_results.png?v=201" style="width: 50%; margin-left: 25%">
    <label>Overview of the annotation results interface</label>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Annotation panel viewer
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Once annotated, the transcript annotation viewer panel provides a graphical representation of the identified
        ORFs. The transcript sequence is represented in blue on the top of the representation. ORFs identified on the
        transcript sequence are represented under the '> > >' symbols. ORFs identified on the reverse complemented
        transcript sequence are represented under the '< < <' symbol.</p>
    <img src="/img/transcript_viewer.png?v=201" alt="/transcript_viewer.png?v=201" style="width: 100%;">
    <label>transcript viewer panel</label>
    <p>For each transcript, either the ncRNA (possibly two for both strand) or the identified ORF(s) are represented by an interactive annotate viewer. This panel provides an
        interactive annotation representation, functional annotation descriptions, homology annotation descriptions.
        Furthermore, the viewer allow the possibility to search transcript, ORFs and proteins sequences in NCBI
        databases.</p>
    <img src="/img/panel.png?v=201" alt="panel.png?v=201" style="width: 100%;">
    <label>annotation viewer panel</label>
    <p>Multiple actions are available through the annotation viewer, such as:</p>
    <ul>
        <li>Detach the panel in a new windows</li>
        <li>Display or hide on the graph the annotations identified by each algorithm</li>
        <li>Select the begin and end position of the transcript region displayed</li>
        <li>Display the panels containing annotation details either for functional annotations or similarity
            annotations
        </li>
        <li>NCBI Blast search can be computed using either the nucleic sequence or the protein sequence if available
        </li>
        <li>Download the sequences of the transcript, coding or non-coding regions, associated protein, and the
            identified annotations
        </li>
    </ul>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Search identified
    annotations
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Search annotations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The search interface allows user to explore available annotated transcripts based on specific criteria. By
        default, searches are made on the whole set of annotation result datasets. Specific datasets can be selected to
        limit the exploration of annotated transcripts. For each identified annotation, a specific annotation can be
        selected. It is also possible to search for any annotation of an algorithm with a minimal and maximal number of
        annotation.</p>
    <img src="/img/search.png?v=201" alt="/search.png?v=201" style="width: 100%;">
    <label>annotation search filters panel</label>
    <p>A summary panel provide the number of ncRNA and ORFs matching the annotation filters, and allow to download the
        sequences and the annotations.</p>
    <img src="/img/results_statistics.png?v=201" alt="/results_statistics.png?v=201" style="width: 100%;">
    <label>annotation search results summary panel</label>
    <p>The ncRNA and ORF matching the annotation filters are displayed in the result panel, with 20 results by page.
        They can be ordered by length, begin position, and end position.</p>
    <img src="/img/results.png?v=201" alt="/results.png?v=201" style="width: 100%;">
    <label>annotation search results panel</label>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Administration of annotation results
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Manage annotations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The annotation management interface list the annotated transcripts datasets with their computation current status,
        annotation parameters, results, and the possibility to rename or delete them. For each dataset, the transcripts
        sequences, the ORFs sequences, and the annotation can be downloaded.</p>
    <img src="/img/manage_annotations.png?v=201" alt="/manage_annotations.png?v=201" style="width: 100%;">
    <label></label>
    <p>The transcript dataset details panel provides the dataset information, ORF identification parameters, functional
        annotation algorithms and their threshold or e-value, similarity annotation references and their identity and
        coverage threshold are available.</p>
    <img src="/img/annotation_dataset_details.png?v=201" alt="/annotation_dataset_details.png?v=201" style="width: 100%;">
    <label>annotation dataset details panel</label>
    <p></p>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Administration of homology references
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Create a homology
    reference
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Datasets of nucleic or proteomic sequences can be used as
        references for annotating submitted transcripts by homology. Admin users can create homology reference by
        providing a FASTA file or an ftp link.</p>
    <img src="/img/create_reference.png?v=201" alt="/create_reference.png?v=201" style="width: 100%;">
    <label>Overview of the interface to create homology references</label>
    <p></p>
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Manage homology references
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The list of all available homology references can be displayed with their current computation status and
        sequence. Through this interface, it is possible to rename or delete the homology reference. The details of
        each homology reference can be displayed to provide the
        release, the species, the sequence type, and the description of the reference.</p>
    <img src="/img/manage_references.png?v=201" alt="/manage_references.png?v=201" style="width: 100%;">
    <label>Overview of the interface to manage references</label>
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Import homology references
    from public databases
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Transcriptomic and proteomic datasets from the NONCODE, UniRef and Ensembl databases can be easily imported as
        reference homologies. For each dataset, a description and an external link to the public database are
        provided.</p>
    <img src="/img/external_references_noncode.png?v=201" alt="/external_references_noncode.png?v=201" style="width: 100%;">
    <label>17 datasets from the NONCODE database can be easily imported in Genotate</label>
    <p></p>
    <img src="/img/external_references_uniref.png?v=201" alt="/external_references_uniref.png?v=201" style="width: 100%;">
    <label>5 datasets from the UniRef database can be easily imported in Genotate</label>
    <p></p>
    <img src="/img/external_references_ensembl.png?v=201" alt="/external_references_ensembl.png?v=201" style="width: 100%;">
    <label>Around 300 datasets from the Ensembl database can be easily imported in Genotate</label>
    <p></p>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Configuration of the Genotate
    platform
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Parallelization of
    annotation computations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Genotate annotation computations can be parallelized for efficient computations of large transcript datasets. The
        pipeline can execute simultaneously multiple process, called workers. The number of workers is configured by
        default to 8 and can be specified by the users.</p>
    <img src="/img/parallelization.png?v=201" alt=img/parallelization.png?v=201 style="width: 100%;">
    <label>parallelization strategy</label>
    <p>For each annotation query, the whole pool of identified ncRNAs and ORFs is split in subsets of 100 sequences. For
        each subset, sequences are annotated by the different algorithms. Each algorithm annotation is computed by
        multiple workers. The annotation obtained are unified in a common result file.</p>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Dependencies configuration
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>To annotate transcripts datasets, the web platform uses a local annotation pipeline. The annotation pipeline is
        launched with Java. The web platform allows to create reference datasets for similarity annotation, and BLAST is
        required to generate a sequence database for each reference dataset. The web platform requires several folders
        to store the uploaded transcripts and reference datasets, to store the files generated by the annotation
        pipeline including the annotation result files.</p>
    <p>The web platform configuration file 'web/genotateweb.config' is required to use the web platform dependencies
        interface and contains the path to each folder and binaries required to run properly. The annotation pipeline
        binaries are automatically downloaded from GitHub in a binaries folder. The folders are automatically generated
        if they do not exist.</p>
    <img src="/img/dependencies_configuration_1.png?v=201" alt="/dependencies_configuration_1.png?v=201" style="width: 100%;">
    <label>web platform dependencies panel</label>
    <p>The annotation pipeline configuration file 'binaries/genotate.config' is required to use the annotation pipeline
        dependencies panel. The annotation pipeline require annotation algorithms and similarity annotation datasets to
        be installed. Genotate annotation pipeline dependencies can be installed by following the instruction available
        at https://github.com/tchitchek-lab/genotate.life.</p>
    <img src="/img/dependencies_configuration_2.png?v=201" alt="/dependencies_configuration_2.png?v=201" style="width: 100%;">
    <label>annotation pipeline dependencies panel</label>
    <p></p>
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Annotation colors
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>This interface allows modifying the color associated to each homology and functional annotations in the graphical
        representations of transcript sequences.</p>
    <img src="/img/annotation_colors.png?v=201" alt=img/annotation_colors.png?v=201 style="width: 100%;">
    <label>annotation colors panel</label>
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Database configuration
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Genotate requires a database management system (DBMS) to store multiple information (such as annotation results,
        associated parameters, algorithm information, homology reference dataset information, user information, ...).
        The database configuration interface allows users to initialize and configure the Genotate database. Users can
        provide
        here the hostname, database name, user name, and password. The database can be reset using this interface. The
        database can be created if the database does not
        already exist. </p>
    <img src="/img/database_configuration.png?v=201" alt="/database_configuration.png?v=201" style="width: 100%;">
    <label>database configuration panel</label>
    <p></p>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Configuration of algorithms and databases
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Algorithms used for the
    identification of functional annotations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Many public algorithms are used by Genotate to identify functional annotations on the transcript sequences. These
        algorithms are described in the table below.</p>
    <table>
        <thead>
        <tr style="font-weight: bold;">
            <td style="width: 15%">names</sub></td>
            <td style="width: 40%">description</sub></td>
            <td style="width: 35%">hosting institutes</sub></td>
            <td style="width: 10%">website links</sub></td>
        </tr>
        </thead>
        <tr>
            <td align="center"><sub>BEPIPRED</sub></td>
            <td align="center"><sub>An epitope, also known as antigenic determinant, is the part of an antigen that is
                    recognized by the immune system, specifically by antibodies, B cells. Predict the location of linear
                    B cell epitopes using a combination of a hidden Markov model and a propensity scale method</sub>
            </td>
            <td align="center"><sub>Center for Biological Sequence Analysis, BioCentrum-DTU, Building 208, Technical
                    University of Denmark</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>CATH-Gene3D</sub></td>
            <td align="center"><sub>CATH-Gene3D database describes protein families and domain architectures in
                    complete genomes. Protein family clusters are identified according to sequence identity. For each
                    protein family conserved domain, a protein structure is available. CATH-Gene3D is based at
                    University College, London, UK.</sub></td>
            <td align="center"><sub>CATH-Gene3D is based at University College, London, UK.</sub></td>
            <td align="center"><a href='http://gene3d.biochem.ucl.ac.uk/' target='_blank'><img src="/img/link.svg"
                                                                                               style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                               align="middle"></a></td>
        </tr>
        <tr>
            <td align="center"><sub>CDD</sub></td>
            <td align="center"><sub>CDD is a collection of annotated multiple sequence alignment models. These are
                    available as position-specific score matrices (PSSMs) for fast identification of conserved domains
                    in protein sequences via RPS-BLAST. CDD content includes NCBI-curated domain models, as well as
                    domain models imported from a number of external source databases.</sub></td>
            <td align="center"><sub>The National Center for Biotechnology Information (NCBI) is part of the United
                    States National Library of Medicine (NLM), a branch of the National Institutes of Health.</sub></td>
            <td align="center"><sub><a href='https://www.ncbi.nlm.nih.gov/cdd/' target='_blank'><img src="/img/link.svg"
                                                                                                     style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                                     align="middle"></a><sub>
            </td>
        </tr>
        <tr>
            <td align="center"><sub>Coils</sub></td>
            <td align="center"><sub>Predicts coiled coil conformation</sub></td>
            <td align="center"><sub>SIB Swiss Institute of Bioinformatics</sub></td>
            <td align="center"><sub><a href='http://embnet.vital it.ch/software/COILS_form.html' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>HAMAP</sub></td>
            <td align="center"><sub>HAMAP stands for High-quality Automated and Manual Annotation of Proteins.
                    HAMAP profiles are manually created by expert curators. They identify proteins that are part of
                    well-conserved proteins families or subfamilies. </sub></td>
            <td align="center"><sub>HAMAP is based at the SIB Swiss Institute of Bioinformatics, Geneva,
                    Switzerland.</sub></td>
            <td align="center"><sub><a href='http://hamap.expasy.org/' target='_blank'><img src="/img/link.svg"
                                                                                            style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                            align="middle"></a><sub>
            </td>
        </tr>
        <tr>
            <td align="center"><sub>Interproscan</sub></td>
            <td align="center"><sub>InterproScan software uses the protein family patterns to search functional
                    domains on proteins. Proteins family allows to group proteins with the same function, and conserved
                    domains can be identified in a family. Databases of proteins family provide a large number of
                    pattern and conserved domains. </sub></td>
            <td align="center"><sub>EMBL EBI in Hinxton, The Wellcome Genome Campus</sub></td>
            <td align="center"><sub><a href='https://github.com/ebi&#45;pf&#45;team/interproscan' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>MHCI</sub></td>
            <td align="center"><sub>An epitope, also known as antigenic determinant, is the part of an antigen that is
                    recognized by the immune system, specifically by antibodies, T cells. MHC I from IEDB database
                    determine each subsequence's ability to bind to a specific MHC class I molecule</sub></td>
            <td align="center"><sub>Division of Vaccine Discovery, La Jolla Institute for Allergy and Immunology</sub>
            </td>
            <td align="center"><sub><a href='http://tools.iedb.org/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>MHCII</sub></td>
            <td align="center"><sub>An epitope, also known as antigenic determinant, is the part of an antigen that is
                    recognized by the immune system, specifically by antibodies, T cells. MHC II from IEDB database
                    predict MHC Class II epitopes, including a consensus approach which combines NN align, SMM align and
                    Combinatorial library methods</sub></td>
            <td align="center"><sub>Division of Vaccine Discovery, La Jolla Institute for Allergy and Immunology</sub>
            </td>
            <td align="center"><sub><a href='http://tools.iedb.org/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>MobiDB</sub></td>
            <td align="center"><sub>MobiDB offers a centralized resource for annotation of intrinsic protein
                    disorder. The database features three levels of annotation: manually curated, indirect and
                    predicted. </sub></td>
            <td align="center"><sub>MobiDB is based at Padua (Italy) in the Biocomputing UP research group, part of the
                    Department of Biomedical Sciences, University of Padua.</sub></td>
            <td align="center"><sub><a href='http://mobidb.bio.unipd.it/' target='_blank'><img src="/img/link.svg"
                                                                                               style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                               align="middle"></a><sub>
            </td>
        </tr>
        <tr>
            <td align="center"><sub>NETCGLYC</sub></td>
            <td align="center"><sub>Glycosylation attach covalently a carbohydrate to proteins and lipids. Some proteins
                    require being glycosylated to fold correctly. NetCGlyc produces neural network predictions of
                    C-mannosylation sites in mammalian proteins.</sub></td>
            <td align="center"><sub>Department of Medical Biochemistry and Biophysics, Karolinska Institutet, SE-171 77
                    Stockholm, Sweden and Stockholm Bioinformatics Center</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>NETNGLYC</sub></td>
            <td align="center"><sub>Glycosylation attach covalently a carbohydrate to proteins and lipids. Some proteins
                    require being glycosylated to fold correctly. NetNglyc predicts N-Glycosylation sites in human
                    proteins using artificial neural networks.</sub></td>
            <td align="center"><sub>Center for Biological Sequence Analysis, The Technical University of Denmark,
                    Lyngby, Denmark</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Panther</sub></td>
            <td align="center"><sub>PANTHER is a large collection of protein families that have been subdivided
                    into functionally related subfamilies, using human expertise. These subfamilies have a more specific
                    function, conserved domain, and provide models for classifying additional protein sequences. </sub>
            </td>
            <td align="center"><sub>PANTHER is based at University of Southern California, CA, US.</sub></td>
            <td align="center"><sub><a href='http://www.pantherdb.org/' target='_blank'><img src="/img/link.svg"
                                                                                             style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                             align="middle"></a><sub>
            </td>
        </tr>
        <tr>
            <td align="center"><sub>Pfam</sub></td>
            <td align="center"><sub>Pfam is a large collection of multiple sequence alignments and hidden Markov
                    models covering many common protein domains. </sub></td>
            <td align="center"><sub>Pfam is based at EMBL-EBI, Hinxton, UK.</sub></td>
            <td align="center"><sub><a href='http://pfam.xfam.org/' target='_blank'><img src="/img/link.svg"
                                                                                         style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                         align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>PIRSF</sub></td>
            <td align="center"><sub>PIRSF protein classification system is a network with multiple levels of
                    sequence diversity from superfamilies to subfamilies that reflects the evolutionary relationship of
                    full-length proteins and domains.</sub></td>
            <td align="center"><sub>PIRSF is based at the Protein Information Resource, Georgetown University Medical
                    Centre, Washington DC, US.</sub></td>
            <td align="center"><sub><a href='http://pir.georgetown.edu/pirwww/search/pirsfscan.shtml'
                                       target='_blank'><img src="/img/link.svg"
                                                            style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                            align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>PRINTS</sub></td>
            <td align="center"><sub>PRINTS is a compendium of protein fingerprints. A fingerprint is a group of
                    conserved motifs used to characterize a protein family or domain.</sub></td>
            <td align="center"><sub>PRINTS is based at the University of Manchester, UK.</sub></td>
            <td align="center"><sub><a href='http://130.88.97.239/PRINTS/index.php' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>ProDom</sub></td>
            <td align="center"><sub>ProDom protein domain database consists of an automatic compilation of
                    homologous domains. Current versions of ProDom are built using a novel procedure based on recursive
                    PSI-BLAST searches. </sub></td>
            <td align="center"><sub>ProDom is based at PRABI Villeurbanne, France.</sub></td>
            <td align="center"><sub><a href='http://prodom.prabi.fr/prodom/current/html/home.php' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>PROSITE</sub></td>
            <td align="center"><sub>PROSITE is a database of protein families and domains. It consists of
                    biologically significant sites, patterns, and profiles that help to reliably identify to which known
                    protein family a new sequence belongs.</sub></td>
            <td align="center"><sub>PROSITE is base at the Swiss Institute of Bioinformatics (SIB), Geneva,
                    Switzerland.</sub></td>
            <td align="center"><sub><a href='http://prosite.expasy.org/' target='_blank'><img src="/img/link.svg"
                                                                                              style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                              align="middle"></a><sub>
            </td>
        </tr>
        <tr>
            <td align="center"><sub>Prop</sub></td>
            <td align="center"><sub>ProP predicts arginine and lysine propeptide cleavage sites, which characterize
                    inactive peptides precursors. The precursors undergo post translational processing to become
                    biologically active polypeptides.</sub></td>
            <td align="center"><sub>Center for Biological Sequence Analysis, BioCentrum DTU, Technical University of
                    Denmark</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/services/ProP/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>rnammer</sub></td>
            <td align="center"><sub>Annotates ribosomal RNA genes</sub></td>
            <td align="center"><sub>Centre for Molecular Biology and Neuroscience and Institute of Medical Microbiology, University of Oslo</sub>
            </td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/services/RNAmmer/' target='_blank'><img src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px' align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Signalp</sub></td>
            <td align="center"><sub>SIGNALP predicts the secretory signal peptide, a ubiquitous signal that targets for
                    translocation across the membrane, based on neural network.</sub></td>
            <td align="center"><sub>Center for Biological Sequence Analysis, Department of Systems Biology,
                    <br>Technical University of Denmark, Lyngby, Denmark.
                    <br>Novo Nordisk Foundation, Center for Protein Research, Health Sciences Faculty, University of
                    Copenhagen, Copenhagen, Denmark.
                    <br>Center for Biomembrane Research, Department of Biochemistry and Biophysics, Stockholm
                    University, Stockholm, Sweden.
                    <br>Science for Life Laboratory, Stockholm University, Solna, Sweden.
                </sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/services/SignalP/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>SFLD</sub></td>
            <td align="center"><sub>SFLD (Structure-Function linkage Database) is a hierarchical classification of
                    enzymes that relates specific sequence-structure features to specific chemical capabilities.</sub>
            </td>
            <td align="center"><sub>UC San Francisco, Babbitt Lab, SFLD Team</sub></td>
            <td align="center"><sub><a href='http://sfld.rbvi.ucsf.edu/django/web/networks/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>SMART</sub></td>
            <td align="center"><sub>SMART (a Simple Modular Architecture Research Algorithm) allows the
                    identification and annotation of genetically mobile domains and the analysis of domain
                    architectures. </sub></td>
            <td align="center"><sub>SMART is based at EMBL, Heidelberg, Germany.</sub></td>
            <td align="center"><sub><a href='http://smart.embl&#45;heidelberg.de/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>SUPERFAMILY</sub></td>
            <td align="center"><sub>SUPERFAMILY is a library of profile hidden Markov models that represent all
                    proteins of known structure. </sub></td>
            <td align="center"><sub>SUPERFAMILY is based at the University of Bristol, UK.</sub></td>
            <td align="center"><sub><a href='http://supfam.org/SUPERFAMILY/' target='_blank'><img src="/img/link.svg"
                                                                                                  style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                                  align="middle"></a><sub>
            </td>
        </tr>
        <tr>
            <td align="center"><sub>Tmhmm</sub></td>
            <td align="center"><sub>TMHMM predicts transmembrane domains and the cellular location of the inter-
                    transmembrane domains, based on hidden Markov models. Transmembrane domains fundamentally rule all
                    the membrane biochemical processes. </sub></td>
            <td align="center"><sub>National Center for Biotechnology Information, NLM/NIH Bethesda & Department of
                    Biochemistry, Arrhenius Laboratory, Stockholm University & Center for Biological Sequence Analysis,
                    Technical University of Denmark</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/services/TMHMM/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>tRNAscan</sub></td>
            <td align="center"><sub>Predicts transfer RNA genes</sub></td>
            <td align="center"><sub>Biomolecular Engineering, University of California Santa Cruz</sub>
            </td>
            <td align="center"><sub><a href='http://lowelab.ucsc.edu/tRNAscan-SE/' target='_blank'><img src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px' align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Tigrfam</sub></td>
            <td align="center"><sub>TIGRFAMs is a collection of protein families, featuring curated multiple
                    sequence alignments, hidden Markov models (HMMs) and annotation, which provides a algorithm for
                    identifying functionally related proteins based on sequence homology.</sub></td>
            <td align="center"><sub>TIGRFAMs is based at the J. Craig Venter Institute, Rockville, MD, US.</sub></td>
            <td align="center"><sub><a href='http://www.jcvi.org/cgi&#45;bin/tigrfams/index.cgi' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
        </tr>
    </table>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Homology reference
    references
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Annotated sequences of the genomes, transcriptomes and proteomes of different species can be used as reference to
        annotate transcripts at the homology level.</p>
    <table>
        <thead>
        <tr style="font-weight: bold;">
            <td align="center" style="width: 10%">names</sub></td>
            <td align="center" style="width: 80%">descriptions</sub></td>
            <td align="center" style="width: 10%">links</sub></td>
        </tr>
        </thead>
        <tr>
            <td align="center"><sub>Ensembl</sub></td>
            <td align="center"><sub>Genome and transcriptome(cds, cdna, ncrna) and proteome for a large number of species</sub></td>
            <td align="center"><sub><a href='http://www.ensembl.org/index.html' target='_blank'>
			<img src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px' align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>NCBI</sub></td>
            <td align="center"><sub>Genome and transcriptome(cds, cdna, ncrna) and proteome for a large number of species</sub></td>
            <td align="center"><sub><a href='https://www.ncbi.nlm.nih.gov/' target='_blank'>
			<img src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px' align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>NONCODE</sub></td>
            <td align="center"><sub>Database dedicated to non-coding RNAs (excluding tRNAs and rRNAs), by species </sub></td>
            <td align="center"><sub><a href='http://www.noncode.org/' target='_blank'>
			<img src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px' align="middle"></a><sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Uniprot</sub></td>
            <td align="center"><sub>UniProtKB/TrEMBL contains high quality computationally analyzed records that are
                    enriched with automatic annotation and classification. <br>Swissprot contains high quality manually
                    annotated and non&#45;redundant protein sequence database.</sub></td>
            <td align="center"><sub><a href='http://www.uniprot.org/downloads' target='_blank'>
			<img src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px' align="middle"></a><sub>
            </td>
        </tr>
    </table>
</div>

<!--

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Web algorithm
</div>
<div class="div-border" style="margin-bottom: 10px;">
    Genotate can be used through a web algorithm to perform annotation of transcript sequences. The RCurl package can be used to sumbmit the transcript sequences and retrive the annotation results.
   // <?php
   // include($_SERVER['DOCUMENT_ROOT'] . "/includes/web_service.php");
   // ?>
</div>



<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Browser compatibilities
</div>
<div class="div-border" style="margin-bottom: 10px;">
    Genotate has been tested on several OS and browser. Here are detailed the different compatibilities.
    <table style="width: 100%">
        <tbody>
        <tr>
            <td>OS</td>
            <td>Version</td>
            <td>Chrome</td>
            <td>Firefox</td>
            <td>Microsoft Edge</td>
            <td>Safari</td>
        </tr>
        <tr>
            <td>Linux</td>
            <td>CentOS 7</td>
            <td>not tested</td>
            <td>61.0</td>
            <td>n/a</td>
            <td>n/a</td>
        </tr>
        <tr>
            <td>MacOS</td>
            <td>HighSierra</td>
            <td>not tested</td>
            <td>61.0</td>
            <td>n/a</td>
            <td>12.0</td>
        </tr>
        <tr>
            <td>Windows</td>
            <td>10</td>
            <td>not tested</td>
            <td>61.0</td>
            <td>42.17134.1.0</td>
            <td>n/a</td>
        </tr>
        </tbody>
    </table>

</div>

-->
<script>
    create_links();
</script>

<script>
    document.title = "Genotate.life - Tutorial";
</script>
