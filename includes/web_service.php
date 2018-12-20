<!-- HTML generated using hilite.me --><div style="background: #ffffff; overflow:auto;width:100%;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;"><pre style="margin: 0; line-height: 125%">library(<span style="background-color: #fff0f0">&#39;RCurl&#39;</span>) <span style="color: #888888"># load the RCurl package or install it if not present</span>

curl <span style="color: #333333">&lt;-</span> getCurlHandle() <span style="color: #888888"># create a Curl handler</span>
tmpcookiefile <span style="color: #333333">&lt;-</span> tempfile(<span style="background-color: #fff0f0">&quot;curl-cookie&quot;</span>, fileext <span style="color: #333333">=</span> <span style="background-color: #fff0f0">&quot;.txt&quot;</span>) <span style="color: #888888"># define a temporary file for cookie session</span>
curlSetOpt(cookiejar<span style="color: #333333">=</span>tmpcookiefile, useragent <span style="color: #333333">=</span> <span style="background-color: #fff0f0">&quot;RCurl&quot;</span>, followlocation <span style="color: #333333">=</span> <span style="color: #008800; font-weight: bold">TRUE</span>, curl<span style="color: #333333">=</span>curl) <span style="color: #888888"># define the user agent as &quot;RCurl&quot;</span>

<span style="color: #888888"># step 1. submit a sequence to the Genotate plaform</span>
parameters <span style="color: #333333">=</span> list(myseq<span style="color: #333333">=</span><span style="color: #6600EE; font-weight: bold">1</span>,
				  sequence<span style="color: #333333">=</span><span style="background-color: #fff0f0">&quot;>ENST00000610381.1 LILRA3-215 cdna:protein_coding
CTCACTGCCACACACAGCTCAGCCTGGGCTGCACAGCCAGGTGTCAGGTGCGTCTCTGCTGATCTGAGTCCACCCTGCAGCATGGACCTGCATCTTCCCTGAAGGATCTCCAGGGCTGGA
GGGACGACTGCCATGCACCGAGGGCTCATCCATCCACAGAGCAGTGCAGTGGGAGGAGACGCCATGACCCCCATCCTCACGGTCCTGATCTGTCTCGGGCTGAGCCTGGACCCCAGGACC
CACGTGCAGGCAGGGCCCCTCCCCAAGCCCACCCTCTGGGCTGAGCCAGGCTCTGTGATCACCCAAGGGAGTCCTGTGACCCTCAGGTGTCAGGGGAGCCTGGAGACGCAGGAGTACCAT
CTATATAGAGAAAAGAAAACAGCACTCTGGATTACACGGATCCCACAGGAGCTTGTGAAGAAGGGCCAGTTCCCCATCCTATCCATCACCTGGGAACATGCAGGGCGGTATTGCTGTATC
TATGGCAGCCACACTGCAGGCCTCTCAGAGAGCAGTGACCCCCTGGAGCTGGTGGTGACAGGAGCCTACAGCAAACCCACCCTCTCAGCTCTGCCCAGCCCTGTGGTGACCTCAGGAGGG
AATGTGACCATCCAGTGTGACTCACAGGTGGCATTTGATGGCTTCATTCTGTGTAAGGAAGGAGAAGATGAACACCCACAATGCCTGAACTCCCATTCCCATGCCCGTGGGTCATCCCGG
GCCATCTTCTCCGTGGGCCCCGTGAGCCCAAGTCGCAGGTGGTCGTACAGGTGCTATGGTTATGACTCGCGCGCTCCCTATGTGTGGTCTCTACCCAGTGATCTCCTGGGGCTCCTGGTC
CCAGGTGTTTCTAAGAAGCCATCACTCTCAGTGCAGCCGGGTCCTGTCGTGGCCCCTGGGGAGAAGCTGACCTTCCAGTGTGGCTCTGATGCCGGCTACGACAGATTTGTTCTGTACAAG
GAGTGGGGACGTGACTTCCTCCAGCGCCCTGGCCGGCAGCCCCAGGCTGGGCTCTCCCAGGCCAACTTCACCCTGGGCCCTGTGAGCCGCTCCTACGGGGGCCAGTACACATGCTCCGGT
GCATACAACCTCTCCTCCGAGTGGTCGGCCCCCAGCGACCCCCTGGACATCCTGATCACAGGACAGATCCGTGCCAGACCCTTCCTCTCCGTGCGGCCGGGCCCCACAGTGGCCTCAGGA
GAGAACGTGACCCTGCTGTGTCAGTCACAGGGAGGGATGCACACTTTCCTTTTGACCAAGGAGGGGGCAGCTGATTCCCCGCTGCGTCTAAAATCAAAGCGCCAATCTCATAAGTACCAG
GCTGAATTCCCCATGAGTCCTGTGACCTCGGCCCACGCGGGGACCTACAGGTGCTACGGCTCACTCAGCTCCAACCCCTACCTGCTGACTCACCCCAGTGACCCCCTGGAGCTCGTGGTC
TCAGGAGCAGCTGAGACCCTCAGCCCACCACAAAACAAGTCCGACTCCAAGGCTGGAGCAGCTGATACCCTCAGCCCATCACAAAACAACCCAACCTCACACCCCCAGGATTACACAGTG
GAGAATCTCATCCACATGGGCAAGGCTGGCTTGATCCTGGTGGTCCTCAGGATTCTGTTATTTGAGGCTCAGCACAGCCAGAGAAGCCCCTAAGATGCAGCTAGGAGGTGAACAGCAGAG
AGGACAATGCATCTCTCAGAGTGGTGGAACCTTGGGAATAGATATGGTGATCCCAGGAGGTTCCGGGAGACAATTTAGGGCCAATGCTATCTGGACTGTCTGCTGATAATTTCTAGAAGG
AGGAATCAGTGTTGGATTGCAGAGATATTTTGCAGGGTGATCCATGGAGGACCATTAACATGTGATACCTTTCCTCTCTATTAATGTTGACTTCCCTTGGTTGGATCCCCT\n&quot;</span>,
				  start_codon<span style="color: #333333">=</span><span style="background-color: #fff0f0">&quot;ATG&quot;</span>,
				  stop_codon<span style="color: #333333">=</span><span style="background-color: #fff0f0">&quot;TAG,TGA,TAA&quot;</span>,
				  description<span style="color: #333333">=</span><span style="background-color: #fff0f0">&quot;&quot;</span>,
				  email<span style="color: #333333">=</span><span style="background-color: #fff0f0">&quot;&quot;</span>,
				  db_name<span style="color: #333333">=</span><span style="background-color: #fff0f0">&quot;&quot;</span>)
postForm(<span style="background-color: #fff0f0">&quot;https://genotate.life/api/compute_annotations.php&quot;</span>,.params <span style="color: #333333">=</span> parameters, curl<span style="color: #333333">=</span>curl)[<span style="color: #6600EE; font-weight: bold">1</span>]


<span style="color: #888888"># step 2. get the annotation results for the dataset 5d3eca81a233</span>
postForm(<span style="background-color: #fff0f0">&quot;https://genotate.life/api/get_annotations.php&quot;</span>,.params <span style="color: #333333">=</span> list(encode_id<span style="color: #333333">=</span><span style="color: #6600EE; font-weight: bold">5</span>d3eca81a233), curl<span style="color: #333333">=</span>curl)[<span style="color: #6600EE; font-weight: bold">1</span>]
</pre></div>
