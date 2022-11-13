# RTVUitzendingen
RTVUitzendingen is een website project bedoeld voor radiostations voor het centraal beheren van de radioprogrammering. Het heeft een gebruikersvriendelijke dashboard voor het bijwerken van de programmering en de presentatie daarvan kan als html in eigen website worden geimplementeerd. Ook is de radioprogrammering als xml/json beschikbaar voor externe systemen.

Dit project bevat ook de mogelijkheid om uitzendingen te selecteren voor "uitzending-gemist" of "opnieuw beluisteren". De ontwikkelaar moet wel een eigen verwerkingsproces voor de audio bouwen.  Voor meer uitleg, zie verderop.

## !! WAARSCHUWING !!

**Het systeem stampt uit de beginjaren 2000 en heeft onderhoud nodig. Dit project is dan ook bedoeld als basis voor een eigen implementatie voor het beheren van een radioprogrammering en uitzending-gemist.**

## Installatie
Dit systeem bestaat uit PHP files met MySql tabellen.

* Importeer de tabellen uit de map 'database' in een MySql database. 
* Kopieer de PHP scripts uit de map 'webfiles' naar een publieke folder op de webserver met PHP ondersteuning. 
* Bewerk het bestand 'system/config/config.php' met de juiste database connectie settings. 
* Ga met de browser naar de root (index.php).

Het standaard beheeraccount voor het dashboard is: **admin**, wachtwoord: **admin100**. **Verander het wachtwoord!!**

## Programmering bijwerken
1. Log aan op het dashboard, klik op programmering
2. Selecteer een weekdag
3. Voeg, wijzijg of verwijder een programma

Iedere dag begint om 00:00 uur en programma's worden op tijden aaneengesloten ingevoerd. Een programma dat start om 14:00 en het tweede programma is om 16:00, dan is de duur van het eerste programma twee uur (van 14 tot 15:59 uur).

## Programmering presenteren in website 
Voor html, zie de map `programmering`. Bijvoorbeeld `programmering/index.php` om deze in een site te embedden.

## Programmering opvragen als xml of json
Voor Json/Xml data, zie de map `system/data`. Voorbeelden:
* `nownextprograms.php` en `nownextprograms_json.php` voor respectievelijk xml als json wat nu op de radio is en daarna.
* en `programmering.php~ voor de programmering in xml.

## Uitzending gemist
Dit systeem heeft de optie om in het dashboard uitzendingen te selecteren voor uitzending-gemist (teurg beluisteren via app of website). 

De ontwikkelaar moet hiervoor zelf een verwerkingsproces realiseren die de audio upload naar een map op de webserver of CDN zodat het beschikbaar is met een internet-adres.  

Resources voor het bouwen:
- gebruik `/system/data/ondemandprograms.php` voor xml met uitzendingen geselecteerd voor uitzending-gemist. Er is ook een json variant beschikbaar `ondemandprograms_json.php`.
- voor een voorbeeld met overzicht en speler, zie de map `/uitzendinggemist/index.php`.

## Categorieen (tags)

Programma's kunnen getagd worden. Dit kan in de instellingen van het dashboard worden aangezet. Deze tags komen dan beschikbaar in html of json/xml.

## Over RTVUitzendingen
RTVUitzendingen ontstond in de beginjaren 2000 op initiatief van RTVSoftware en werd in de loop van de tijd door een flink aantal omroepen als basis gebruikt. RTVsoftware is in 2022 gestopt met de doorontwikkeling en als open source beschikbaar gesteld. 
