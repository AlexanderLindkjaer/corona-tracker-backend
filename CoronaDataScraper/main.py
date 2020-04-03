import tabula
import requests
from pathlib import Path
from bs4 import BeautifulSoup


def getRegionIncidents():
    soup = BeautifulSoup(requests.get(
        'https://www.ssi.dk/aktuelt/sygdomsudbrud/coronavirus/covid-19-i-danmark-epidemiologisk-overvaagningsrapport').text,
                         'html.parser')
    links = soup.blockquote.find_all('a')
    link = links[1].get('href')

    head, sep, tail = link.partition('?')

    print(head)

    data = tabula.read_pdf_with_template(
        head, Path('template-1.json'),
        output_format='json')

    dict = {}

    for row in data[0]['data']:
        dict[row[0]['text']] = {'confirmed_cases': row[1]['text'], 'population': row[2]['text'],
                                'cumulative_incidence': row[3]['text']}

    for row in data[1]['data']:
        dict[row[0]['text']] = {'confirmed_cases': row[1]['text'], 'population': row[2]['text'],
                                'cumulative_incidence': row[3]['text']}

    # api = 'http://api.coronatracker.test/api/upload-region-incidents'
    api = 'https://api.coronatracker.dk/api/upload-region-incidents'

    r = requests.post(url=api, json=dict)

    print(r.status_code)
    print(r.text)


def getOfficialStats():
    soup = BeautifulSoup(requests.get('https://www.sst.dk/da/corona/tal-og-overvaagning').text, 'html.parser')

    trs = soup.find_all('tr')[1]

    dict = {}
    index = 0

    # first table, second row
    for td in trs.find_all('td'):
        index = index + 1
        val = extractNumber(td.get_text())

        if (index == 2):
            dict['Antal testede'] = val

        if (index == 3):
            dict['Antal registrerede smittede'] = val

        if (index == 4):
            dict['Antal overstået infektion'] = val

        if (index == 5):
            dict['Antal døde'] = val

    table2 = soup.find_all('table')[2]
    trs2 = table2.find_all('tr')[6]
    index = 0

    # third table, 7th row
    for td in trs2.find_all('td'):
        index = index + 1
        val = extractNumber(td.get_text())

        if (index == 2):
            dict['Antal indlagte på hospitalerne'] = val

        if (index == 3):
            dict['Antal patienter på intensivafdelinger'] = val

        if (index == 4):
            dict['Antal patienter i respirator'] = val


    sortedDict = {
        'Antal døde': dict['Antal døde'],
        'Antal indlagte på hospitalerne': dict['Antal indlagte på hospitalerne'],
        'Antal patienter på intensivafdelinger': dict['Antal patienter på intensivafdelinger'],
        'Antal patienter i respirator': dict['Antal patienter i respirator'],
        'Antal registrerede smittede': dict['Antal registrerede smittede'],
        'Antal testede': dict['Antal testede'],
        'Antal overstået infektion': dict['Antal overstået infektion'],
    }

    #api = 'http://api.coronatracker.test/api/upload-stats'
    api = 'https://api.coronatracker.dk/api/upload-stats'

    r = requests.post(url=api, json=dict)

    print(r.status_code)
    print(r.text)


def extractNumber(number):
    alphanumeric = ""
    for character in number:
        if character.isalnum() or character == ',':
            alphanumeric += character

    return alphanumeric


if __name__ == '__main__':
    getRegionIncidents()
    getOfficialStats()
