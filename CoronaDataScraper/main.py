import tabula
import requests
from pathlib import Path
from bs4 import BeautifulSoup




def getRegionIncidents():

    soup = BeautifulSoup(requests.get('https://www.ssi.dk/aktuelt/sygdomsudbrud/coronavirus/covid-19-i-danmark-epidemiologisk-overvaagningsrapport').text, 'html.parser')
    links = soup.blockquote.find_all('a')
    link = links[1].get('href')

    head, sep, tail = link.partition('?')

    print(head)

    data = tabula.read_pdf_with_template(
        head, Path('template-1.json'),
        output_format='json')


    dict = {}

    for row in data[0]['data']:
        dict[row[0]['text']] = {'confirmed_cases': row[1]['text'], 'population': row[2]['text'], 'cumulative_incidence': row[3]['text'] }

    for row in data[1]['data']:
        dict[row[0]['text']] = {'confirmed_cases': row[1]['text'], 'population': row[2]['text'],
                                'cumulative_incidence': row[3]['text']}

    #api = 'http://api.coronatracker.test/api/upload-region-incidents'
    api = 'https://api.coronatracker.dk/api/upload-region-incidents'

    r = requests.post(url=api, json=dict)

    print(r.status_code)
    print(r.text

if __name__ == '__main__':
    getRegionIncidents()
