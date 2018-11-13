# Genotate: a web platform for automatic annotation, research and visualization of transcriptomic sequences

Genotate web platform provide automatic annotation, research, and visualization of transcriptomic sequences.
Reference transcriptome and proteome can be selected for homology annotation, depending on the databases available.
Database and prediction tools can be selected for the functional annotation.
The identified annotation for each ORF is provided by an interactive panel.
A graph represents the sequence and identified annotations, and the annotations descriptions are available in optional panels.
The annotated ORF can be filtered to display and compare a subset of ORF with a specific annotation.

Genotate is available at [Genotate Website](http://www.genotate.life).


# Table of Contents

1. [Introduction](#Introduction)
2. [Installation requirements](#Requirement)
3. [Installation of Genotate web server](#Installation)
4. [References](#references)

# <a name="Introduction"/> 1. Introduction

Genotate website allows to access automatic annotation pipeline for transcript sequence anywhere, and the access to annotated sequences for exploration.
Genotate use an Apache server to access HTML files from the web.

Genotate use Genotate annotation software to annotate the transcript sequences.
Homology annotation databases can be created and managed, using Ensembl transcriptomes and proteomes, UniProt proteomic databases, or custom sequences.

Genotate searches all the ORF and annotates them using similarity to other sequences and functional domains.
The tools parameters can be modified through the website.

<img src="img/workflow.png"/>

# <a name="Overview"/> 2. Installation requirements

Genotate use a web server and a SQL server, we recommand Apache server and MySQL server.

Genotate use Genotate for automatic ORF identification, similarity annotation and functional annotation.

## Installation of apache

Apache server can be installed using the following command
```
sudo apt-get update
sudo apt-get install apache2
sudo apt-get install apache2 apache2-utils
sudo apt install php
apt install libapache2-mod-php7.0
apt-get install php7.0-mysqli
```

The apache virtual host file needs to be configured to allow the access to genotate by the web, available at /etc/apache2/sites-available.
```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/genotate/web
    ServerName www.youraddress.life
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

www-data may not be able to launch InterproScan.
In this case, it is necessary to reset the user www-data right with the following command.
```
service apache2 stop
killall -u www-data
userdel -f www-data
adduser www-data
```

The transcript files and sequence files used on the website can be very large. It is necessary to change the php upload limit to allow larger file. The php.ini file can be found at /etc/php/7.0/apache2/php.ini
```
upload_max_filesize = 2g
post_max_size = 2g
```

The service apache 2 can be restarted to take into account the modifications, with the following command.
```
sudo service apache2 restart
```

## Installation of MySQL

The annotated ORF are loaded on the website, using a database MySQL to store the information.
The MySQL database allows the creation of SQL query to select a subset of ORF based on the selected experiment and for specific annotation.
The website provides an interface to create and manage the database MySQL.

MySQL server can be installed using the following command
```
curl -OL https://dev.mysql.com/get/mysql-apt-config_0.8.3-1_all.deb
dpkg -i mysql-apt-config*
sudo apt-get update
sudo apt-get install mysql-server
sudo mysqladmin -u root password newpass -p oldpass
```

## Installation of Java

Java is used to launch Genotate and can be downloaded at [java.com](https://www.java.com/fr/download/linux_manual.jsp).
Please install java in services/java/bin/java.

## Installation of phpMyAdmin (optionally)

phpMyAdmin can be installed using the following command
```
apt-get install phpmyadmin
apt-get install phpmyadmin php-mbstring php-gettext
ln -s /usr/share/phpmyadmin/ /var/www/genotate/web/phpmyadmin
```

## Installation of Genotate automatic annotation platform

Genotate need to be installed and configured to launch annotation from Genotate website.

To install Genotate annotation tool please go to [Genotate Github](https://github.com/tchitchek-lab/genotate).

Any folder name and website name can be used, it will not affect genotate functions.
The user right needs to be configured to allow apache to execute genotate, services, and create files.

You can set www-data the default user of genotate folder with the following command.
```
chown -R www-data [path to genotate]
chgrp -R www-data [path to genotate]
```

# <a name="Installation"/> 3. Installation of Genotate web server

## Installation of the main directories

Genotate can be downloaded with the following command.
```
mkdir /var/www/genotate
cd /var/www/genotate
git clone --depth 1  https://github.com/tchitchek-lab/genotate.web
mv genotate.web web
```

Genotate need subfolders to work:
 * web contains the HTML, PHP, CSS and js files necessary to the website.
 * binaries contain genotate.jar and genotate.config.
 * services contain the tools used to run genotate.
 * tmp contains the temporary sequence which are annotated using Genotate, and the resulting files.
 * workspace/blastdb contains the databases used for annotation by homology.
 * workspace/storage contains the results files, the annotated transcripts, generated by Genotate.
 * workspace/config contains the database.config file with the MySQL user, pass and the name of Genotate database.

PHPMyAdmin can be installed in the web/PHPMyAdmin folder to administrate directly MySQL databases.

Genotate can notify the user by mail when a query is finished. The web system needs to be installed with the following command.
```
apt-get install postfix
```

## Installation of UserSpice

Inside the web folder, install userspice which provides libraries and a database for user management.

```
cd /var/www/genotate/web
wget https://github.com/mudmin/UserSpice4/archive/master.zip
unzip master.zip
mv UserSpice4-master userspice
chown -R www-data /var/www/genotate/web/userspice
chgrp -R www-data /var/www/genotate/web/userspice
```

Open your web adress matching www.genotate.life/userspice/ and follow UserSpice configuration.

Move userspice configuration file in genotate users folder.

```
cp /var/www/genotate/web/userspice/users/init.php /var/www/genotate/web/users/init.php
```

# <a name="References"/> 4. References

[1] E. R. Mardis, “The impact of next-generation sequencing technology on genetics,” Trends in Genetics, vol. 24, no. 3. pp. 133–141, 2008.

[2] E. J. Fox, K. S. Reid-Bayliss, M. J. Emond, and L. a Loeb, “Accuracy of Next Generation Sequencing Platforms.,” Next Gener. Seq. Appl., 2014.

[3] M. C. Frith, M. Pheasant, and J. S. Mattick, “The amazing complexity of the human transcriptome.,” Eur. J. Hum. Genet., vol. 13, no. 8, pp. 894–7, 2005.

[4] M. A. Quail et al., “A large genome center’s improvements to the Illumina sequencing system.,” Nat. Methods, 2008.

[5] A. Rhoads and K. F. Au, “PacBio Sequencing and Its Applications,” Genomics, Proteomics and Bioinformatics. 2015.

[6] D. Branton et al., “The potential and challenges of nanopore sequencing.,” Nat. Biotechnol., 2008.

[7] K. Paszkiewicz and D. J. Studholme, “De novo assembly of short sequence reads,” Brief. Bioinform., vol. 11, no. 5, pp. 457–472, 2010.

[8] L. Stein, “Genome annotation: from sequence to biology.,” Nat. Rev. Genet., vol. 2, no. 7, pp. 493–503, 2001.

[9] S. McGinnis and T. L. Madden, “BLAST: At the core of a powerful and diverse set of sequence analysis tools,” Nucleic Acids Res., 2004.

[10] P. Jones et al., “InterProScan 5: Genome-scale protein function classification,” Bioinformatics, vol. 30, no. 9, pp. 1236–1240, 2014.