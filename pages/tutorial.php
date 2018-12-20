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
    <p>The Genotate platform allows the automatic annotation of transcript sequences. Annotations can be predicted based on sequence homology and structural analyses at both the transcript and amino acid levels. Identified annotations can be easily visualized using interactive viewers. Furthermore, users can search for transcripts having specific features among their annotation results.
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
        techniques are more and more precise and the acquisition costs are constantly decreasing [1]. Especially,
        RNA-seq [2] (NGS) can be used to characterize the transcriptome [3] of new animal species or specific cell
        types.</p>
    <p>RNA-seq technologies generally produce fragments of transcriptomic sequences, named reads, which need to be
        assembled. Illumina [4] is one of the most used RNA-seq techniques and can sequence reads up to hundreds of
        bases. The PacBio [5] and the Nanopore [6] techniques can sequence reads up to hundreds of kilo-bases. Reads are
        usually assembled into transcripts with different algorithms [7].</p>
    <p>Once assembled, transcripts must be annotated. Transcript annotations can be defined either at the homology or structural levels.
        Firstly, transcripts can be annotated based on their homology with transcriptomic annotated
        references [8-9]. Secondly, proteins translated from transcript sequences can be annotated based on their
        homology with proteomic annotated references [10], and based on their peptidic domains.</p>
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
    <img src="/img/functionalities.png" alt="/functionalities.png" style="width: 100%;">
    <label>Overview of the Genotate user interface</label>
    <img src="/img/admin.png" alt="/functionalities.png" style="width: 100%;">
    <label>Overview of the Genotate administration user interface</label>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Overview of the annotation
    workflow
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The Genotate annotation pipeline takes in input one fasta file containing a single transcript or multiple transcripts. The annotation steps and options are defined using the web interface. For each reconstructed transcript, Genotate first detects the set of all possible ORFs with the purpose of annotating them. All ORFs detected by Genotate are annotated based on: (i) their homology with other reference sequences, also named homology annotations; and (ii) the presence of peptidic functional elements on their resulting translated proteins, also named functional annotations. Homology annotations are computed based on any reference dataset of transcriptomic or proteomic sequences specified by users or available by default in Genotate. The functional annotations are computed based on a compendium of publicly available computational tools and databases specified by the user.</p>

    <p>A large collection of annotation services and databases are available in Genotate. Indeed, reference transcriptomic and proteomic datasets from the NONCODE, UniRef, and Ensembl databases are available (consisting of more than 100 animal species). Additionally, multiple protein annotation software are available (consisting in around 30 different algorithms). Non-coding transcripts can also be analyzed with Genotate.</p>
        <img src="/img/workflow.png" alt="workflow.png" style="width: 100%;">
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
    <p>Each interface provides the different options to parametrize the ORF detection, homology, and structural
        analyses.</p>
    <img src="/img/single_transcript_annotation.png" alt="/single_transcript_annotation.png"
         style="width: 50%; margin-left: 25%">
    <label>Overview of the interface to annotate a single transcript </label>
    <img src="/img/multiple_transcripts_annotation.png" alt="/multiple_transcripts_annotation.png"
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
        also be identified as well as outside ORF (which consist of ORFs lacking either the start or stop codon). By
        default, the complete transcript sequence is conserved to be annotated as a non-coding RNA. By default, ORFs are
        also identified on the reverse complemented transcript sequence.</p>
    <img src="/img/orf_identification_panel.png" alt="orf_identification_panel.png"
         style="width: 50%; margin-left: 25%">
    <label>Overview of the ORF detection panel</label>
    <p>In detail, the protein associated to a transcript are obtained by detecting all the possible ORF on the transcript. A frame is composed of nucleotide triplets called codon. The transcript sequence is divided into three frames, with a shift of one base on the sequence strand. The transcript sequence can also be reversed, and the nucleic base complemented to obtain the complementary sequence. An Open Reading Frame begins with a codon start and ends with a codon stop. A codon can be translated to an amino acid or end of translation signal. A codon encoding the beginning of the translation, such as 'ATG', is called codon start. A codon encoding the end of the translation, such as 'TAG, TGA, TAA', is called codon stop. A protein is obtained from the translated sequence of an Open Reading Frame.</p>
    <img src="/img/orf_identification.png" alt="orf_identification.png" style="width: 50%; margin-left: 25%">
    <label>ORF identification method</label>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Identification of homology
    annotations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Homology annotations are computed based on any reference dataset of transcriptomic or proteomic sequences specified by users or available by default in Genotate. </p>
    <img src="/img/references.png" alt="references.png" style="width: 100%;">
    <label>Overview of the possible homology references</label>
    <p>Sequences homologies are identified using the BLAST algorithm [9]. Homology results can be filtered based on the percentage identity match, the percentage of query sequence coverage, and the percentage of reference sequence coverage.</p>
    <img src="/img/interface_references.png" alt="references.png" style="width: 100%;">
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
    <img src="/img/functional_annotation_panel.png" alt="/functional_annotation_panel.png"
         style="width: 50%; margin-left: 25%">
    <label>Overview of the homology annotation panel</label>
    <p>In details, the functional annotation are computed based on a large set of publicly available computational
        algorithms and
        databases. Especially, the InterproScan identify conserved functional domains on a protein, and unify multiple
        protein family databases and alignment algorithms. InterproScan unifies proteins functional domains from
        different databases such as PFAM [17], SUPERFAMILY [24], and PANTHER [16]. </p>
    <p>The functional annotation are computed based on multiple other prediction algorithms, such as TMHMM [27],
        SIGNALP [28], PROP [29], PRIAM [26] and SABLE [30].</p>
    <img src="/img/functional.png" alt="functional.png" style="width: 100%;">
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
    <img src="/img/annotation_results.png" alt="annotation_results.png" style="width: 50%; margin-left: 25%">
    <label>Overview of the annotation results interface</label>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Annotation panel viewer
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Once annotated, the transcript annotation viewer panel provides a graphical representation of the identified
        ORFs. The transcript sequence is represented in blue on the top of the representation. ORFs identified on the
        transcript sequence are represented under the '> > >' symbols. ORFs identified on the reverse complemented
        transcript sequence are represented under the '< < <' symbol. Identified inner ORFs (ORFs nested in a larger
        ORFs), outside ORFs (ORFs lacking a start or stop codon), and ncRNA are also represented in this overview
        viewer.</p>
    <img src="/img/transcript_viewer.png" alt="/transcript_viewer.png" style="width: 100%;">
    <label>transcript viewer panel</label>
    <p>Each annotated ncRNA and ORF are represented by an interactive annotate viewer. This panel provides an
        interactive annotation representation, functional annotation descriptions, homology annotation descriptions.
        Furthermore, the viewer allow the possibility to search transcript, ORFs and proteins sequences in NCBI
        databases.</p>
    <img src="/img/panel.png" alt="panel.png" style="width: 100%;">
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
    <img src="/img/search.png" alt="/search.png" style="width: 100%;">
    <label>annotation search filters panel</label>
    <ul>
        <li>A: dataset filter, select regions from a dataset</li>
        <li>B: annotation filter, select regions with selected annotations</li>
        <li>C: keyword filter, on refresh display only the annotation filters containing the keyword</li>
        <li>D: service filter, select regions with annotations from a specific service</li>
        <li>E: name filter, select regions with specific annotations names</li>
        <li>F: minimum number of annotations</li>
        <li>G: any annotations from this service</li>
        <li>H: maximum number of annotations</li>
    </ul>
    <p>A summary panel provide the number of ncRNA and ORFs matching the annotation filters, and allow to download the
        sequences and the annotations.</p>
    <img src="/img/results_statistics.png" alt="/results_statistics.png" style="width: 100%;">
    <label>annotation search results summary panel</label>
    <p>The ncRNA and ORF matching the annotation filters are displayed in the result panel, with 20 results by page.
        They can be ordered by length, begin position, and end position.</p>
    <img src="/img/results.png" alt="/results.png" style="width: 100%;">
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
    <img src="/img/manage_annotations.png" alt="/manage_annotations.png" style="width: 100%;">
    <label></label>
    <ul>
        <li>A: dataset details button, enable a panel with the dataset information</li>
        <li>B: explore dataset, display the dataset annotated regions</li>
        <li>C: rename dataset, allow to change the name of the dataset</li>
        <li>D: delete dataset, allow to delete the dataset</li>
        <li>E: download sequences and annotations</li>
    </ul>
    <p>The transcript dataset details panel provides the dataset information, ORF identification parameters, functional
        annotation algorithms and their threshold or e-value, similarity annotation references and their identity and
        coverage threshold are available.</p>
    <img src="/img/annotation_dataset_details.png" alt="/annotation_dataset_details.png" style="width: 100%;">
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
    <img src="/img/create_reference.png" alt="/create_reference.png" style="width: 100%;">
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
    <img src="/img/manage_references.png" alt="/manage_references.png" style="width: 100%;">
    <label>Overview of the interface to manage references</label>
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Import homology references
    from public databases
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Transcriptomic and proteomic datasets from the NONCODE, UniRef and Ensembl databases can be easily imported as
        reference homologies. For each dataset, a description and an external link to the public database are
        provided.</p>
    <img src="/img/external_references_noncode.png" alt="/external_references_noncode.png" style="width: 100%;">
    <label>17 datasets from the NONCODE database can be easily imported in Genotate</label>
    <p></p>
    <img src="/img/external_references_uniref.png" alt="/external_references_uniref.png" style="width: 100%;">
    <label>5 datasets from the UniRef database can be easily imported in Genotate</label>
    <p></p>
    <img src="/img/external_references_ensembl.png" alt="/external_references_ensembl.png" style="width: 100%;">
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
    <img src="/img/parallelization.png" alt=img/parallelization.png style="width: 100%;">
    <label>parallelization strategy</label>
    <p>For each annotation query, the whole pool of identified ncRNAs and ORFs is split in subsets of 100 sequences. For
        each subset, sequences are annotated by the different algorithms. Each algorithm annotation is computed by
        multiple workers. The annotation obtained are unified in a common result file.</p>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Manage services for
    functional annotation
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>The management interface for the functional annotation algorithm allows to manage the algorithm installation
        status and specified the path to their binaries. The paths for all required binaries are load from
        'genotate.config' file in the folder binaries. The path to each algorithm can be modified. The functional
        annotation algorithms can be installed by following the instruction available at
        https://github.com/tchitchek-lab/genotate.</p>
    <img src="/img/manage_services.png" alt="/manage_services.png" style="width: 100%;">
    <label>services management panel</label>
    <p></p>
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
    <img src="/img/dependencies_configuration_1.png" alt="/dependencies_configuration_1.png" style="width: 100%;">
    <label>web platform dependencies panel</label>
    <p>The annotation pipeline configuration file 'binaries/genotate.config' is required to use the annotation pipeline
        dependencies panel. The annotation pipeline require annotation algorithms and similarity annotation datasets to
        be installed. Genotate annotation pipeline dependencies can be installed by following the instruction available
        at https://github.com/tchitchek-lab/genotate.</p>
    <img src="/img/dependencies_configuration_2.png" alt="/dependencies_configuration_2.png" style="width: 100%;">
    <label>annotation pipeline dependencies panel</label>
    <p></p>
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Annotation colors
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>This interface allows modifying the color associated to each homology and structural annotations in the graphical
        representations of transcript sequences.</p>
    <img src="/img/annotation_colors.png" alt=img/annotation_colors.png style="width: 100%;">
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
    <img src="/img/database_configuration.png" alt="/database_configuration.png" style="width: 100%;">
    <label>database configuration panel</label>
    <p></p>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Configuration of algorithms and databases
</div>
<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Algorithms used for the
    identification of structural annotations
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Many public algorithms are used by Genotate to identify functional annotations on the transcript sequences. These
        algorithms are described in the table below.</p>
    <table>
        <thead>
        <tr style="font-weight: bold;">
            <td style="width: 10%">names</sub></td>
            <td style="width: 40%">description</sub></td>
            <td style="width: 35%">hosting institutes</sub></td>
            <td style="width: 5%">website links</sub></td>
            <td style="width: 10%">references</sub></td>
        </tr>
        </thead>
        <tr>
            <td align="center"><sub>Interproscan</sub></td>
            <td align="center"><sub>InterproScan software [14] uses the protein family patterns to search functional
                    domains on proteins. Proteins family allows to group proteins with the same function, and conserved
                    domains can be identified in a family. Databases of proteins family provide a large number of
                    pattern and conserved domains. </sub></td>
            <td align="center"><sub>EMBL EBI in Hinxton, The Wellcome Genome Campus</sub></td>
            <td align="center"><sub><a href='https://github.com/ebi&#45;pf&#45;team/interproscan' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[12]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Priam</sub></td>
            <td align="center"><sub>Enzymes [30] are biological catalysts which accelerate, the conversion of substrates
                    molecules into products. Metabolic pathways are composed of a set of enzymes and can be predicted if
                    the enzyme available are known. PRIAM detects enzymatic domain with associated functions and
                    nomenclature. </sub></td>
            <td align="center"><sub>The PRABI is the Rhone Alpes Bioinformatics Center, a IBiSA regional center</sub>
            </td>
            <td align="center"><sub><a href='http://priam.prabi.fr/REL_MAR15/index_mar15.html' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[26]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Tmhmm</sub></td>
            <td align="center"><sub>TMHMM [18] predicts transmembrane domains and the cellular location of the inter-
                    transmembrane domains, based on hidden Markov models. Transmembrane domains fundamentally rule all
                    the membrane biochemical processes. </sub></td>
            <td align="center"><sub>National Center for Biotechnology Information, NLM/NIH Bethesda & Department of
                    Biochemistry, Arrhenius Laboratory, Stockholm University & Center for Biological Sequence Analysis,
                    Technical University of Denmark</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/services/TMHMM/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[27]</sub></td>
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
            <td align="center"><sub>[28]</sub></td>
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
            <td align="center"><sub>[29]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Sable</sub></td>
            <td align="center"><sub>Sable [22] use relative solvent accessibility and evolutionary profiles to predict
                    the secondary structure of a protein. Protein secondary structure is the intermediate form of local
                    segments of proteins before the protein folds into its three-dimensional tertiary structure. The two
                    most common secondary structural elements are alpha helices and beta sheets.</sub></td>
            <td align="center"><sub>UC Meller Lab, University of Cincinnati</sub></td>
            <td align="center"><sub><a href='http://sable.cchmc.org/' target='_blank'><img src="/img/link.svg"
                                                                                           style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                           align="middle"></a><sub></td>
            <td align="center"><sub>[30]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Coils</sub></td>
            <td align="center"><sub>Predicts coiled coil conformation</sub></td>
            <td align="center"><sub>SIB Swiss Institute of Bioinformatics</sub></td>
            <td align="center"><sub><a href='http://embnet.vital it.ch/software/COILS_form.html' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[31]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>NETCGLYC</sub></td>
            <td align="center"><sub>Glycosylation attach covalently a carbohydrate to proteins and lipids. Some proteins
                    require being glycosylated to fold correctly. NetCGlyc [31] produces neural network predictions of
                    C-mannosylation sites in mammalian proteins.</sub></td>
            <td align="center"><sub>Department of Medical Biochemistry and Biophysics, Karolinska Institutet, SE-171 77
                    Stockholm, Sweden and Stockholm Bioinformatics Center</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
            <td align="center"><sub>[33]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>NETNGLYC</sub></td>
            <td align="center"><sub>Glycosylation attach covalently a carbohydrate to proteins and lipids. Some proteins
                    require being glycosylated to fold correctly. NetNglyc [32] predicts N-Glycosylation sites in human
                    proteins using artificial neural networks.</sub></td>
            <td align="center"><sub>Center for Biological Sequence Analysis, The Technical University of Denmark,
                    Lyngby, Denmark</sub></td>
            <td align="center"><sub><a href='http://www.cbs.dtu.dk/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
            <td align="center"><sub>[34]</sub></td>
        </tr>
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
            <td align="center"><sub>[35]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>MHCI</sub></td>
            <td align="center"><sub>An epitope, also known as antigenic determinant, is the part of an antigen that is
                    recognized by the immune system, specifically by antibodies, T cells. MHC I from IEDB database [24]
                    determine each subsequence's ability to bind to a specific MHC class I molecule</sub></td>
            <td align="center"><sub>Division of Vaccine Discovery, La Jolla Institute for Allergy and Immunology</sub>
            </td>
            <td align="center"><sub><a href='http://tools.iedb.org/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
            <td align="center"><sub>[36]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>MHCII</sub></td>
            <td align="center"><sub>An epitope, also known as antigenic determinant, is the part of an antigen that is
                    recognized by the immune system, specifically by antibodies, T cells. MHC II from IEDB database [24]
                    predict MHC Class II epitopes, including a consensus approach which combines NN align, SMM align and
                    Combinatorial library methods</sub></td>
            <td align="center"><sub>Division of Vaccine Discovery, La Jolla Institute for Allergy and Immunology</sub>
            </td>
            <td align="center"><sub><a href='http://tools.iedb.org/' target='_blank'><img src="/img/link.svg"
                                                                                          style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                          align="middle"></a><sub></td>
            <td align="center"><sub>[37]</sub></td>
        </tr>
    </table>
</div>

<div class="anchor div-border-subtitle" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Functional annotation
    references
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>Proteins family allows to group proteins with the same function, and conserved domains can be identified in a
        family. Databases of proteins family provide a large number of pattern and conserved domains.</p>
    <table>
        <thead>
        <tr style="font-weight: bold;">
            <td align="center" style="width: 10%">names</sub></td>
            <td align="center" style="width: 40%">descriptions</sub></td>
            <td align="center" style="width: 35%">host institutes</sub></td>
            <td align="center" style="width: 5%">links</sub></td>
            <td align="center" style="width: 10%">references</sub></td>
        </tr>
        </thead>
        <tr>
            <td align="center"><sub>CATH-Gene3D</sub></td>
            <td align="center"><sub>CATH-Gene3D [34] database describes protein families and domain architectures in
                    complete genomes. Protein family clusters are identified according to sequence identity. For each
                    protein family conserved domain, a protein structure is available. CATH-Gene3D is based at
                    University College, London, UK.</sub></td>
            <td align="center"><sub>CATH-Gene3D is based at University College, London, UK.</sub></td>
            <td align="center"><a href='http://gene3d.biochem.ucl.ac.uk/' target='_blank'><img src="/img/link.svg"
                                                                                               style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                               align="middle"></a></td>
            <td align="center"><sub>[14]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>CDD</sub></td>
            <td align="center"><sub>CDD [35] is a collection of annotated multiple sequence alignment models. These are
                    available as position-specific score matrices (PSSMs) for fast identification of conserved domains
                    in protein sequences via RPS-BLAST. CDD content includes NCBI-curated domain models, as well as
                    domain models imported from a number of external source databases.</sub></td>
            <td align="center"><sub>The National Center for Biotechnology Information (NCBI) is part of the United
                    States National Library of Medicine (NLM), a branch of the National Institutes of Health.</sub></td>
            <td align="center"><sub><a href='https://www.ncbi.nlm.nih.gov/cdd/' target='_blank'><img src="/img/link.svg"
                                                                                                     style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                                     align="middle"></a><sub>
            </td>
            <td align="center"><sub>[13]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>MobiDB</sub></td>
            <td align="center"><sub>MobiDB [36] offers a centralized resource for annotation of intrinsic protein
                    disorder. The database features three levels of annotation: manually curated, indirect and
                    predicted. </sub></td>
            <td align="center"><sub>MobiDB is based at Padua (Italy) in the Biocomputing UP research group, part of the
                    Department of Biomedical Sciences, University of Padua.</sub></td>
            <td align="center"><sub><a href='http://mobidb.bio.unipd.it/' target='_blank'><img src="/img/link.svg"
                                                                                               style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                               align="middle"></a><sub>
            </td>
            <td align="center"><sub>[14]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>HAMAP</sub></td>
            <td align="center"><sub>HAMAP [37] stands for High-quality Automated and Manual Annotation of Proteins.
                    HAMAP profiles are manually created by expert curators. They identify proteins that are part of
                    well-conserved proteins families or subfamilies. </sub></td>
            <td align="center"><sub>HAMAP is based at the SIB Swiss Institute of Bioinformatics, Geneva,
                    Switzerland.</sub></td>
            <td align="center"><sub><a href='http://hamap.expasy.org/' target='_blank'><img src="/img/link.svg"
                                                                                            style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                            align="middle"></a><sub>
            </td>
            <td align="center"><sub>[15]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Panther</sub></td>
            <td align="center"><sub>PANTHER [17] is a large collection of protein families that have been subdivided
                    into functionally related subfamilies, using human expertise. These subfamilies have a more specific
                    function, conserved domain, and provide models for classifying additional protein sequences. </sub>
            </td>
            <td align="center"><sub>PANTHER is based at University of Southern California, CA, US.</sub></td>
            <td align="center"><sub><a href='http://www.pantherdb.org/' target='_blank'><img src="/img/link.svg"
                                                                                             style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                             align="middle"></a><sub>
            </td>
            <td align="center"><sub>[16]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Pfam</sub></td>
            <td align="center"><sub>Pfam [15] is a large collection of multiple sequence alignments and hidden Markov
                    models covering many common protein domains. </sub></td>
            <td align="center"><sub>Pfam is based at EMBL-EBI, Hinxton, UK.</sub></td>
            <td align="center"><sub><a href='http://pfam.xfam.org/' target='_blank'><img src="/img/link.svg"
                                                                                         style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                         align="middle"></a><sub></td>
            <td align="center"><sub>[17]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>PIRSF</sub></td>
            <td align="center"><sub>PIRSF [38] protein classification system is a network with multiple levels of
                    sequence diversity from superfamilies to subfamilies that reflects the evolutionary relationship of
                    full-length proteins and domains.</sub></td>
            <td align="center"><sub>PIRSF is based at the Protein Information Resource, Georgetown University Medical
                    Centre, Washington DC, US.</sub></td>
            <td align="center"><sub><a href='http://pir.georgetown.edu/pirwww/search/pirsfscan.shtml'
                                       target='_blank'><img src="/img/link.svg"
                                                            style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                            align="middle"></a><sub></td>
            <td align="center"><sub>[18]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>PRINTS</sub></td>
            <td align="center"><sub>PRINTS [39] is a compendium of protein fingerprints. A fingerprint is a group of
                    conserved motifs used to characterize a protein family or domain.</sub></td>
            <td align="center"><sub>PRINTS is based at the University of Manchester, UK.</sub></td>
            <td align="center"><sub><a href='http://130.88.97.239/PRINTS/index.php' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[19]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>ProDom</sub></td>
            <td align="center"><sub>ProDom [40] protein domain database consists of an automatic compilation of
                    homologous domains. Current versions of ProDom are built using a novel procedure based on recursive
                    PSI-BLAST searches. </sub></td>
            <td align="center"><sub>ProDom is based at PRABI Villeurbanne, France.</sub></td>
            <td align="center"><sub><a href='http://prodom.prabi.fr/prodom/current/html/home.php' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[20]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>PROSITE</sub></td>
            <td align="center"><sub>PROSITE [41] is a database of protein families and domains. It consists of
                    biologically significant sites, patterns, and profiles that help to reliably identify to which known
                    protein family a new sequence belongs.</sub></td>
            <td align="center"><sub>PROSITE is base at the Swiss Institute of Bioinformatics (SIB), Geneva,
                    Switzerland.</sub></td>
            <td align="center"><sub><a href='http://prosite.expasy.org/' target='_blank'><img src="/img/link.svg"
                                                                                              style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                              align="middle"></a><sub>
            </td>
            <td align="center"><sub>[21]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>SFLD</sub></td>
            <td align="center"><sub>SFLD [42] (Structure-Function linkage Database) is a hierarchical classification of
                    enzymes that relates specific sequence-structure features to specific chemical capabilities.</sub>
            </td>
            <td align="center"><sub>UC San Francisco, Babbitt Lab, SFLD Team</sub></td>
            <td align="center"><sub><a href='http://sfld.rbvi.ucsf.edu/django/web/networks/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[22]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>SMART</sub></td>
            <td align="center"><sub>SMART [43] (a Simple Modular Architecture Research Algorithm) allows the
                    identification and annotation of genetically mobile domains and the analysis of domain
                    architectures. </sub></td>
            <td align="center"><sub>SMART is based at EMBL, Heidelberg, Germany.</sub></td>
            <td align="center"><sub><a href='http://smart.embl&#45;heidelberg.de/' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[23]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>SUPERFAMILY</sub></td>
            <td align="center"><sub>SUPERFAMILY [16] is a library of profile hidden Markov models that represent all
                    proteins of known structure. </sub></td>
            <td align="center"><sub>SUPERFAMILY is based at the University of Bristol, UK.</sub></td>
            <td align="center"><sub><a href='http://supfam.org/SUPERFAMILY/' target='_blank'><img src="/img/link.svg"
                                                                                                  style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                                  align="middle"></a><sub>
            </td>
            <td align="center"><sub>[24]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Tigrfam</sub></td>
            <td align="center"><sub>TIGRFAMs [44] is a collection of protein families, featuring curated multiple
                    sequence alignments, hidden Markov models (HMMs) and annotation, which provides a algorithm for
                    identifying functionally related proteins based on sequence homology.</sub></td>
            <td align="center"><sub>TIGRFAMs is based at the J. Craig Venter Institute, Rockville, MD, US.</sub></td>
            <td align="center"><sub><a href='http://www.jcvi.org/cgi&#45;bin/tigrfams/index.cgi' target='_blank'><img
                                src="/img/link.svg" style='margin-left:5px;margin-bottom: 2px; height:50px'
                                align="middle"></a><sub></td>
            <td align="center"><sub>[25]</sub></td>
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
            <td align="center" style="width: 75%">descriptions</sub></td>
            <td align="center" style="width: 5%">links</sub></td>
            <td align="center" style="width: 10%">references</sub></td>
        </tr>
        </thead>
        <tr>
            <td align="center"><sub>Ensembl</sub></td>
            <td align="center"><sub>Transcriptome(cds, cdna, ncrna) and proteome for a large number of species</sub>
            </td>
            <td align="center"><sub><a href='http://www.ensembl.org/index.html' target='_blank'><img src="/img/link.svg"
                                                                                                     style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                                     align="middle"></a><sub>
            </td>
            <td align="center"><sub>[10]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>Uniprot</sub></td>
            <td align="center"><sub>UniProtKB/TrEMBL contains high quality computationally analyzed records that are
                    enriched with automatic annotation and classification. <br>Swissprot contains high quality manually
                    annotated and non&#45;redundant protein sequence database.
                </sub></td>
            <td align="center"><sub><a href='http://www.uniprot.org/downloads' target='_blank'><img src="/img/link.svg"
                                                                                                    style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                                    align="middle"></a><sub>
            </td>
            <td align="center"><sub>[11]</sub></td>
        </tr>
        <tr>
            <td align="center"><sub>NONCODE</sub></td>
            <td align="center"><sub>database dedicated to non-coding RNAs (excluding tRNAs and rRNAs), by species </sub>
            </td>
            <td align="center"><sub><a href='http://www.noncode.org/' target='_blank'><img src="/img/link.svg"
                                                                                           style='margin-left:5px;margin-bottom: 2px; height:50px'
                                                                                           align="middle"></a><sub></td>
            <td align="center"><sub>[38]</sub></td>
        </tr>
    </table>
</div>

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>Web service
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/web_service.php");
    ?>
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

<div class="anchor div-border-title" style='width: 100%;' id='<?php echo $anchor_id++; ?>'>References
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <p>[1] E. R. Mardis, "The impact of next-generation sequencing technology on genetics," Trends in Genetics, vol.
        24,
        no. 3. pp. 133&#45;141, 2008.</p>
    <p>[2] E. J. Fox, K. S. Reid-Bayliss, M. J. Emond, and L. a Loeb, "Accuracy of Next Generation Sequencing
        Platforms.," Next Gener. Seq. Appl., 2014.</p>
    <p>[3] M. C. Frith, M. Pheasant, and J. S. Mattick, "The amazing complexity of the human transcriptome.," Eur.
        J.
        Hum. Genet., vol. 13, no. 8, pp. 894&#45;7, 2005.</p>
    <p>[4] M. A. Quail et al., "A large genome center's improvements to the Illumina sequencing system.," Nat.
        Methods,
        vol. 5, no. 12, pp. 1005&#45;10, 2008.</p>
    <p>[5] A. Rhoads and K. F. Au, "PacBio Sequencing and Its Applications," Genomics, Proteomics and
        Bioinformatics.
        2015.</p>
    <p>[6] D. Branton et al., "The potential and challenges of nanopore sequencing.," Nat. Biotechnol., 2008.</p>
    <p>[7] K. Paszkiewicz and D. J. Studholme, "De novo assembly of short sequence reads," Brief. Bioinform., vol.
        11,
        no. 5, pp. 457&#45;472, 2010.</p>
    <p>[8] L. Stein, "Genome annotation: from sequence to biology.," Nat. Rev. Genet., vol. 2, no. 7, pp. 493&#45;503,
        2001.</p>
    <p>[9] A. Yates et al., "Ensembl 2016," Nucleic Acids Res., vol. 44, no. D1, pp. D710&#45;D716, 2016.</p>
    <p>[10] A. Bairoch et al., "The Universal Protein Resource (UniProt)," Nucleic Acids Res., 2005.</p>
    <p>[11] L. M. Mendes Soares and J. Valcarcel, "The expanding transcriptome: the genome as the 'Book of Sand,'"
        Embo
        J., vol. 25, no. 0261&#45;4189 (Print), pp. 923&#45;931, 2006.</p>
    <p>[12] M. Iyer et al., "The landscape of long noncoding RNAs in the human transcriptome," Nat. Genet., vol. 47,
        no.
        3, pp. 199&#45;208, 2015.</p>
    <p>[13] S. McGinnis and T. L. Madden, "BLAST: At the core of a powerful and diverse set of sequence analysis
        tools,"
        Nucleic Acids Res., 2004.</p>
    <p>[14] P. Jones et al., "InterProScan 5: Genome-scale protein function classification," Bioinformatics, vol.
        30,
        no. 9, pp. 1236&#45;1240, 2014.</p>
    <p>[15] A. Zuccaro et al., "The Pfam protein families database.," Nucleic Acids Res., 2011.</p>
    <p>[16] M. Madera, C. Vogel, S. K. Kummerfeld, C. Chothia, and J. Gough, "The SUPERFAMILY database in 2004:
        additions and improvements.," Nucleic Acids Res., vol. 32, no. Database issue, pp. D235-9, 2004.</p>
    <p>[17] P. D. Thomas et al., "PANTHER: A library of protein families and subfamilies indexed by function,"
        Genome
        Res., vol. 13, no. 9, pp. 2129&#45;2141, 2003.</p>
    <p>[18] E. L. Sonnhammer, G. von Heijne, and A. Krogh, "A hidden Markov model for predicting transmembrane
        helices
        in protein sequences.," Proceedings, vol. 6, pp. 175&#45;182, 1998.</p>
    <p>[19] T. N. Petersen, S. Brunak, G. von Heijne, and H. Nielsen, "SignalP 4.0: discriminating signal peptides
        from
        transmembrane regions," Nat. Methods, vol. 8, no. 10, pp. 785&#45;6, 2011.</p>
    <p>[20] P. Duckert, S. Brunak, and N. Blom, "Prediction of proprotein convertase cleavage sites," Protein Eng.
        Des.
        Sel., vol. 17, no. 1, pp. 107&#45;112, 2004.</p>
    <p>[21] A. Bairoch, "The ENZYME database in 2000.," Nucleic Acids Res., 2000.</p>
    <p>[22] R. Adamczak, A. Porollo, and J. Meller, "Combining prediction of secondary structure and solvent
        accessibility in proteins," Proteins Struct. Funct. Genet., vol. 59, no. 3, pp. 467&#45;475, 2005.</p>
    <p>[23] M. Ashburner et al., "Gene Ontology: Tool for The Unification of Biology," Nat. Genet., 2000.</p>
    <p>[24] R. Vita et al., "The immune epitope database (IEDB) 3.0," Nucleic Acids Res., vol. 43, no. D1, pp. D405&#45;D412,
        2015.</p>
    <p>[25] J. E. P. Larsen, O. Lund, and M. Nielsen, "Improved method for predicting linear B-cell epitopes.,"
        Immunome
        Res., vol. 2, p. 2, 2006.</p>
    <p>[26] B. Rost and J. Liu, "The PredictProtein server," Nucleic Acids Res., vol. 31, no. 13, pp. 3300&#45;3304,
        2003.</p>
    <p>[27] A. Mitchell et al., "The InterPro protein families database: The classification resource after 15
        years,"
        Nucleic Acids Res., vol. 43, no. D1, pp. D213&#45;D221, 2015.</p>
    <p>[28] S. C. Potter et al., "The Ensembl analysis pipeline," Genome Res., vol. 14, no. 5, pp. 934&#45;941,
        2004.</p>
    <p>[29] D. Vallenet et al., "MicroScope: A platform for microbial genome annotation and comparative genomics,"
        Database, vol. 2009, 2009.</p>
    <p>[30] A. Bairoch, "The ENZYME database in 2000.," Nucleic Acids Res., vol. 28, no. 1, pp. 304&#45;5, 2000.</p>
    <p>[31] K. Julenius, "NetCGlyc 1.0: Prediction of mammalian C-mannosylation sites," Glycobiology, vol. 17, no.
        8,
        pp. 868&#45;876, 2007.</p>
    <p>[32] N. Blom, T. Sicheritz-Ponten, R. Gupta, S. Gammeltoft, and S. Brunak, "Prediction of post-translational
        glycosylation and phosphorylation of proteins from the amino acid sequence," Proteomics, vol. 4, no. 6. pp.
        1633&#45;1649,
        2004.</p>
    <p>[33] a Lupas, M. Van Dyke, and J. Stock, "Predicting coiled coils from protein sequences.," Science, vol.
        252,
        no. 5010, pp. 1162&#45;4, 1991.</p>
    <p>[34] J. Lees, C. Yeats, O. Redfern, A. Clegg, and C. Orengo, "Gene3D: Merging structure and function for a
        thousand genomes," Nucleic Acids Res., vol. 38, no. SUPPL.1, 2009.</p>
    <p>[35] A. Marchler-Bauer et al., "CDD: A Conserved Domain Database for protein classification," Nucleic Acids
        Res.,
        vol. 33, no. DATABASE ISS., 2005.</p>
    <p>[36] E. Potenza, T. Di Domenico, I. Walsh, and S. C. E. Tosatto, "MobiDB 2.0: An improved database of
        intrinsically disordered and mobile proteins," Nucleic Acids Res., vol. 43, no. D1, pp. D315&#45;D320,
        2015.</p>
    <p>[37] T. Lima et al., "HAMAP: A database of completely sequenced microbial proteome sets and manually curated
        microbial protein families in UniProtKB/Swiss-Prot," Nucleic Acids Res., vol. 37, no. SUPPL. 1, 2009.</p>
    <p>[38] C. H. Wu et al., "PIRSF: family classification system at the Protein Information Resource.," Nucleic
        Acids
        Res., vol. 32, no. Database issue, pp. D112-4, 2004.</p>
    <p>[39] T. K. Attwood et al., "PRINTS and its automatic supplement, prePRINTS," Nucleic Acids Research, vol. 31,
        no.
        1. pp. 400&#45;402, 2003.</p>
    <p>[40] F. Servant, "ProDom: Automated clustering of homologous domains," Brief. Bioinform., vol. 3, no. 3, pp.
        246&#45;251,
        2002.</p>
    <p>[41] C. J. A. Sigrist et al., "PROSITE, a protein domain database for functional characterization and
        annotation," Nucleic Acids Res., vol. 38, no. SUPPL.1, 2009.</p>
    <p>[42] E. Akiva et al., "The Structure-Function linkage Database," Nucleic Acids Res., vol. 42, no. D1,
        2014.</p>
    <p>[43] I. Letunic, T. Doerks, and P. Bork, "SMART 6: Recent updates and new developments," Nucleic Acids Res.,
        vol.
        37, no. SUPPL. 1, 2009.</p>
    <p>[44] J. D. Selengut et al., "TIGRFAMs and Genome Properties: Tools for the assignment of molecular function
        and
        biological process in prokaryotic genomes," Nucleic Acids Res., vol. 35, no. SUPPL. 1, 2007.</p>
</div>

<script>
    create_links();
</script>

<script>
    document.title = "Genotate.life - Tutorial";
</script>
