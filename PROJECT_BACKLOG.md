# Keuzedeel Website - Project Backlog

## Project Overview
Het project heeft als doel een webapplicatie te ontwikkelen waarmee studenten keuzedelen kunnen kiezen en inschrijven, administratiemedewerkers het proces kunnen beheren, en SLBers informatie kunnen presenteren aan klassen.

## Epics & User Stories

### Epic 1: Authenticatie & Autorisatie
**Priority: High**

#### User Stories:
- **Als** student **wil ik** met mijn Microsoft schoolaccount kunnen inloggen **zodat** ik toegang heb tot het systeem
- **Als** administratiemedewerker **wil ik** met mijn Microsoft account kunnen inloggen **zodat** ik toegang heb tot de beheerfuncties
- **Als** SLBer **wil ik** met mijn Microsoft account kunnen inloggen **zodat** ik toegang heb tot de presentatiemodus
- **Als** systeem **wil ik** de rol van de gebruiker automatisch detecteren op basis van Microsoft account **zodat** de juiste rechten worden toegekend
- **Als** systeem **wil ik** voorkomen dat studenten van andere opleidingen toegang krijgen **zodat** de data veilig blijft
- **Als** beheerder **wil ik** kunnen zien welke gebruikers toegang hebben gehad **zodat** ik de veiligheid kan monitoren

### Epic 2: Keuzedeel Informatiebeheer
**Priority: High**

#### User Stories:
- **Als** administratiemedewerker **wil ik** keuzedelen kunnen aanmaken, bewerken en verwijderen **zodat** de informatie actueel blijft
- **Als** administratiemedewerker **wil ik** keuzedelen kunnen in- en uitschakelen zonder data te verliezen **zodat** ik flexibel kan beheren
- **Als** administratiemedewerker **wil ik** de beschrijving, duur, periode en docent kunnen specificeren **zodat** studenten volledige informatie hebben
- **Als** administratiemedewerker **wil ik** kunnen instellen of een keuzedeel meerdere keren gevolgd mag worden **zodat** de regels correct worden toegepast
- **Als** administratiemedewerker **wil ik** het minimum (15) en maximum (30) aantal studenten per keuzedeel kunnen instellen **zodat** de groepsgrootte gereguleerd wordt
- **Als** student **wil ik** per keuzedeel gedetailleerde informatie kunnen zien **zodat** ik een weloverwogen keuze kan maken
- **Als** student **wil ik** kunnen zien of ik een keuzedeel al heb afgerond **zodat** ik niet onnodig opnieuw inschrijf
- **Als** student **wil ik** kunnen filteren op beschikbare keuzedelen per periode **zodat** ik relevante opties zie

### Epic 3: Inschrijfsysteem
**Priority: High**

#### User Stories:
- **Als** student **wil ik** me kunnen inschrijven voor een beschikbaar keuzedeel **zodat** ik deelname kan garanderen
- **Als** student **wil ik** mijn inschrijving kunnen wijzigen voordat de periode sluit **zodat** ik van keuze kan veranderen
- **Als** student **wil ik** een bevestiging ontvangen na succesvolle inschrijving **zodat** ik zeker weet dat het gelukt is
- **Als** student **wil ik** kunnen zien hoeveel plekken er nog beschikbaar zijn **zodat** ik mijn kansen kan inschatten
- **Als** student **wil ik** automatisch naar mijn 2e keuze gaan als 1e keuze vol is **zodat** ik altijd een plek krijg
- **Als** systeem **wil ik** voorkomen dat een student zich inschrijft voor een keuzedeel dat al is afgerond **zodat** er geen dubbele inschrijvingen zijn
- **Als** systeem **wil ik** de "wie het eerst komt, wie het eerst maalt" regel toepassen **zodat** het eerlijk verloopt
- **Als** student **wil ik** maar voor één keuzedeel per periode kunnen inschrijven **zodat** ik overbelasting voorkom

### Epic 4: Administratief Overzicht
**Priority: High**

#### User Stories:
- **Als** administratiemedewerker **wil ik** een overzicht zien van alle inschrijvingen per keuzedeel **zodat** ik de voortgang kan volgen
- **Als** administratiemedewerker **wil ik** kunnen exporteren naar Excel/CSV **zodat** ik de data kan verwerken in andere systemen
- **Als** administratiemedewerker **wil ik** studenten handmatig kunnen toevoegen/verwijderen **zodat** ik uitzonderingen kan behandelen
- **Als** administratiemedewerker **wil ik** zien welke keuzedelen onvoldoende inschrijvingen hebben (<15) **zodat** ik actie kan ondernemen
- **Als** administratiemedewerker **wil ik** de inschrijfperiode kunnen openen en sluiten **zodat** ik controle heb over het timing
- **Als** administratiemedewerker **wil ik** notificaties ontvangen wanneer keuzedelen vol of bijna vol zijn **zodat** ik proactief kan handelen

### Epic 5: Presentatiemodus voor SLBers
**Priority: Medium**

#### User Stories:
- **Als** SLBer **wil ik** de keuzedeelinformatie in een powerpoint-achtige presentatie kunnen bekijken **zodat** ik het makkelijk aan de klas kan presenteren
- **Als** SLBer **wil ik** kunnen navigeren tussen keuzedelen met vorige/volgende knoppen **zodat** de presentatie soepel verloopt
- **Als** SLBer **wil ik** een overzichtsslide kunnen tonen met alle keuzedelen **zodat** studenten een totaalbeeld krijgen
- **Als** SLBer **wil ik** de presentatie in fullscreen modus kunnen bekijken **zodat** er geen afleiding is
- **Als** SLBer **wil ik** de presentatie kunnen printen of opslaan als PDF **zodat** ik het kan delen met afwezige studenten

### Epic 6: Notificaties & Communicatie
**Priority: Medium**

#### User Stories:
- **Als** student **wil ik** een email ontvangen wanneer de inschrijfperiode opent **zodat** ik op tijd kan inschrijven
- **Als** student **wil ik** een herinnering ontvangen voordat de inschrijfperiode sluit **zodat** ik geen deadline mis
- **Als** student **wil ik** geïnformeerd worden wanneer een keuzedeel niet doorgaat **zodat** ik een alternatief kan kiezen
- **Als** administratiemedewerker **wil ik** berichten kunnen sturen naar specifieke groepen studenten **zodat** ik gericht kan communiceren
- **Als** student **wil ik** mijn inschrijvingsstatus kunnen volgen **zodat** ik op de hoogte blijf

### Epic 7: Rapportage & Analyse
**Priority: Low**

#### User Stories:
- **Als** administratiemedewerker **wil ik** statistieken kunnen zien over populaire keuzedelen **zodat** ik het aanbod kan optimaliseren
- **Als** administratiemedewerker **wil ik** historische data kunnen bekijken **zodat** ik trends kan analyseren
- **Als** beheerder **wil ik** gebruiksstatistieken kunnen zien **zodat** ik de systeemprestaties kan monitoren
- **Als** administratiemedewerker **wil ik** kunnen zien welke studenten nog niet hebben ingeschreven **zodat** ik hen kan herinneren

## Technische Vereisten

### Microsoft Azure AD Integratie
- OAuth 2.0 implementatie
- Role-based access control
- User profile synchronization
- Group-based authorization

### Database Schema
- Users (Microsoft ID, roles, study program)
- Keuzedelen (title, description, period, capacity, repeatable)
- Inschrijvingen (user_id, keuzedeel_id, timestamp, status)
- Periods (start_date, end_date, enrollment_open)

### Performance Requirements
- Ondersteuning voor 500+ gelijktijdige gebruikers
- Response time < 2 seconden
- Mobile responsive design

### Security Requirements
- HTTPS verplicht
- Input validation en sanitization
- Rate limiting
- Audit logging

## Onbekende Factoren & Risico's

### Technische Risico's
- **Microsoft AD integratie complexiteit**: Moet onderzocht worden of de school Azure AD ondersteunt
- **Data migratie**: Bestaande data moet mogelijk geïmporteerd worden
- **Performance**: Bij veel gelijktijdige inschrijvingen

### Functionele Risico's
- **Gelijkijdige inschrijvingen**: Race conditions bij "vol=vol"
- **Data consistentie**: Meerdere administratiemedewerkers tegelijk
- **User experience**: Complexiteit van het inschrijfproces

### Aanbevelingen voor Opdrachtgever
1. **Technische verkenningsfase**: Onderzoek naar Microsoft AD mogelijkheden
2. **Data workshop**: Inzicht in huidige processen en data
3. **User testing**: Prototypes met studenten en administratie
4. **Phased rollout**: Start met basisfunctionaliteit

## Planning Suggestie

### Sprint 1 (2 weken): Foundation
- Microsoft AD authenticatie setup
- Basis database schema
- User roles en permissions

### Sprint 2 (2 weken): Core functionality
- Keuzedeel CRUD operations
- Basis inschrijfsysteem
- Student dashboard

### Sprint 3 (2 weken): Advanced features
- Administratief overzicht
- Capacity management
- Presentatiemodus

### Sprint 4 (2 weken): Polish & Testing
- Notificatiesysteem
- Rapportages
- User testing en bugfixes

## Acceptatiecriteria
Per user story worden specifieke acceptatiecriteria gedefinieerd tijdens de sprint planning.
