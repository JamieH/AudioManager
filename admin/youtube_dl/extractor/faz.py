# encoding: utf-8
import re
import xml.etree.ElementTree

from .common import InfoExtractor
from ..utils import (
    determine_ext,
    clean_html,
    get_element_by_attribute,
)


class FazIE(InfoExtractor):
    IE_NAME = u'faz.net'
    _VALID_URL = r'https?://www\.faz\.net/multimedia/videos/.*?-(?P<id>\d+).html'

    _TEST = {
        u'url': u'http://www.faz.net/multimedia/videos/stockholm-chemie-nobelpreis-fuer-drei-amerikanische-forscher-12610585.html',
        u'file': u'12610585.mp4',
        u'info_dict': {
            u'title': u'Stockholm: Chemie-Nobelpreis für drei amerikanische Forscher',
            u'description': u'md5:1453fbf9a0d041d985a47306192ea253',
        },
    }

    def _real_extract(self, url):
        mobj = re.match(self._VALID_URL, url)
        video_id = mobj.group('id')
        self.to_screen(video_id)
        webpage = self._download_webpage(url, video_id)
        config_xml_url = self._search_regex(r'writeFLV\(\'(.+?)\',', webpage,
            u'config xml url')
        config_xml = self._download_webpage(config_xml_url, video_id,
            u'Downloading config xml')
        config = xml.etree.ElementTree.fromstring(config_xml.encode('utf-8'))

        encodings = config.find('ENCODINGS')
        formats = []
        for code in ['LOW', 'HIGH', 'HQ']:
            encoding = encodings.find(code)
            if encoding is None:
                continue
            encoding_url = encoding.find('FILENAME').text
            formats.append({
                'url': encoding_url,
                'ext': determine_ext(encoding_url),
                'format_id': code.lower(),
            })

        descr_html = get_element_by_attribute('class', 'Content Copy', webpage)
        info = {
            'id': video_id,
            'title': self._og_search_title(webpage),
            'formats': formats,
            'description': clean_html(descr_html),
            'thumbnail': config.find('STILL/STILL_BIG').text,
        }
        # TODO: Remove when #980 has been merged
        info.update(formats[-1])
        return info
