# RTVUitzendingen
RTVUitzendingen is een webproject voor radiostations voor het beheren van de radioprogrammering. Het kent een gebruikersvriendelijke dashboard voor het beheer en de presentatie kan als html in de eigen website worden geimplementeerd. Ook is de programmering in xml of json beschikbaar voor andere externe systemen.

Dit project bevat ook de mogelijkheid om uitzendingen te selecteren voor "uitzending-gemist" of "opnieuw beluisteren". Er moet zelf een verwerkingsproces worden ontwikkeld voor het beschikbaar stellen van de audio zelf.  Voor meer uitleg hierover, zie verderop.

## !! WAARSCHUWING !!

**Dit project begon in 2000 en is niet up-to-date. Dit webproject is dan ook bedoeld als basis voor een eigen implementatie van het beheren van een radioprogrammering en uitzending-gemist, en moet door de ontwikkelaar zelfstandig worden aangepast.**

## Installatie
Dit systeem bestaat uit PHP files met een MySql database.

* Importeer de tabellen uit de map 'database' in een MySql database. 
* Kopieer de PHP scripts uit de map 'webfiles' naar een publieke folder op de webserver met PHP ondersteuning. 
* Bewerk het bestand 'system/config/config.php' met de juiste database connectie settings. 
* Ga met de browser naar de root (index.php).

Het standaard beheeraccount voor het dashboard is: **admin**, wachtwoord: **admin100**. **Verander het wachtwoord direct!!**

## Programmering bijwerken
1. Log aan op het dashboard, klik op programmering
2. Selecteer een weekdag
3. Voeg, wijzijg of verwijder een programma

Iedere dag begint om 00:00 uur en programma's worden op tijden aaneengesloten gesomd. Een programma dat start om 14:00 en het tweede programma is om 16:00, dan duurt  het eerste programma twee uur (van 14 tot 15:59 uur).

## Programmering presenteren in website 
Voor html, zie de map `programmering`. Bijvoorbeeld `programmering/index.php` voor implementatie in eigen website.

## Programmering opvragen als xml of json
Voor Json/Xml data, zie de map `system/data`. Voorbeelden:
* `nownextprograms.php` en `nownextprograms_json.php` voor respectievelijk xml als json wat nu op de radio is en daarna.
* en `programmering.php~ voor de programmering in xml.

## Uitzending gemist
Dit systeem heeft ook de optie om in het dashboard uitzendingen te selecteren voor uitzending-gemist (teurg beluisteren via app of website). 

De ontwikkelaar moet zelf een verwerkingsproces realiseren die de audio upload naar een map op de webserver of een ander CDN zodat het beschikbaar komt voor de website of app. De audio moet als http(s) url beschikbaar zijn.  

Resources voor het bouwen:
- gebruik `/system/data/ondemandprograms.php` voor xml met uitzendingen geselecteerd voor uitzending-gemist. Er is ook een json variant beschikbaar `ondemandprograms_json.php`.
- voor een voorbeeld met overzicht en speler, zie de map `/uitzendinggemist/index.php`.

## Categorieen (tags)

Programma's kunnen getagd worden. Dit kan in de instellingen van het dashboard worden aangezet. Deze tags komen dan beschikbaar in html of json/xml.

## Over RTVUitzendingen
RTVUitzendingen ontstond in de beginjaren 2000 op initiatief van RTVSoftware en werd in de loop van de tijd door een flink aantal omroepen in de basis gebruikt. RTVsoftware is in 2022 gestopt met het doorontwikkelen en ondersteuning daarvoor en stelt het nu beschikbaar als open source. De tool die voorheen beschikbaar was voor het uploaden van audio is niet meer beschikbaar.
