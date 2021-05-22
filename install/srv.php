<?php
$config = array();
require('../libs/config.inc.php');
require('../libs/mysql.inc.php');

/* ----- EU ----- */
$srvUE = array('Aegwynn','Aerie Peak','Agamaggan','Aggramar','Ahn\'Qiraj','Al\'Akir','Alexstrasza','Alleria','Alonsus','Aman\'Thul','Ambossar','Anachronos',
'Anetheron','Antonidas','Anub\'arak','Arak-arahm','Arathi','Arathor','Archimonde','Area 52','Argent Dawn','Arthas','Arygos','Aszune','Auchindoun',
'Azjol-Nerub','Azshara','Azuremyst','Baelgun','Balnazzar','Blackhand','Blackmoore','Blackrock','Blade\'s Edge','Bladefist','Bloodfeather',
'Bloodhoof','Bloodscalp','Blutkessel','Boulderfist','Bronze Dragonflight','Bronzebeard','Burning Blade','Burning Legion','Burning Steppes','C\'Thun',
'Chamber of Aspects','Chants \u00e9ternels','Cho\'gall','Chromaggus','Colinas Pardas','Confr\u00e9rie du Thorium','Conseil des Ombres','Crushridge',
'Culte de la Rive noire','Daggerspine','Dalaran','Dalvengyr','Darkmoon Faire','Darksorrow','Darkspear','Das Konsortium','Das Syndikat','Deathwing',
'Defias Brotherhood','Dentarg','Der Mithrilorden','Der Rat von Dalaran','Der abyssische Rat','Destromath','Dethecus','Die Aldor','Die Arguswacht',
'Die Nachtwache','Die Silberne Hand','Die Todeskrallen','Die ewige Wacht','Doomhammer','Draenor','Dragonblight','Dragonmaw','Drak\'thul','Drek\'Thar',
'Dun Modr','Dun Morogh','Dunemaul','Durotan','Earthen Ring','Echsenkessel','Eitrigg','Eldre\'Thalas','Elune','Emerald Dream','Emeriss','Eonar',
'Eredar','Executus','Exodar','Festung der St\u00fcrme','Fizzcrank','Forscherliga','Frostmane','Frostmourne','Frostwhisper','Frostwolf',
'Garona','Garrosh','Genjuros','Ghostlands','Gilneas','Gorgonnash','Grim Batol','Gul\'dan','Hakkar','Haomarush','Hellfire',
'Hellscream','Hyjal','Illidan','Jaedenar','Kael\'thas','Karazhan','Kargath','Kazzak','Kel\'Thuzad','Khadgar','Khaz Modan','Khaz\'goroth',
'Kil\'jaeden','Kilrogg','Kirin Tor','Kor\'gall','Krag\'jin','Krasus','Kul Tiras','Kult der Verdammten','La Croisade \u00e9carlate','Laughing Skull',
'Les Clairvoyants','Les Sentinelles','Lightbringer','Lightning\'s Blade','Lordaeron','Los Errantes','Lothar','Madmortem','Magtheridon',
'Mal\'Ganis','Malfurion','Malorne','Malygos','Mannoroth','Mar\u00e9cage de Zangar','Mazrigos','Medivh','Minahonda','Molten Core','Moonglade',
'Mug\'thol','Nagrand','Nathrezim','Naxxramas','Nazjatar','Nefarian','Neptulon','Ner\'zhul','Nera\'thor','Nethersturm','Nordrassil',
'Norgannon','Nozdormu','Onyxia','Outland','Perenolde','Proudmoore','Quel\'Thalas','Ragnaros','Rajaxx','Rashgarroth','Ravencrest','Ravenholdt',
'Rexxar','Runetotem','Sanguino','Sargeras','Saurfang','Scarshield Legion','Sen\'jin','Shadowmoon','Shadowsong','Shattered Halls','Shattered Hand','Shattrath',
'Shen\'dralar','Silvermoon','Sinstralis','Skullcrusher','Spinebreaker','Sporeggar','Steamwheedle Cartel','Stonemaul','Stormrage','Stormreaver',
'Stormscale','Sunstrider','Suramar','Sylvanas','Taerar','Talnivarr','Tarren Mill','Teldrassil','Temple noir','Terenas','Terokkar','Terrordar','The Maelstrom',
'The Sha\'tar','The Venture Co','Theradras','Thrall','Throk\'Feroth','Thunderhorn','Tichondrius','Tirion','Todeswache','Trollbane','Turalyon',
'Twilight\'s Hammer','Twisting Nether','Tyrande','Uldaman','Ulduar','Uldum','Un\'Goro','Varimathras','Vashj','Vek\'lor','Vek\'nilash','Vol\'jin','Warsong',
'Wildhammer','Wrathbringer','Xavius','Ysera','Ysondre','Zenedar','Zirkel des Cenarius','Zul\'jin','Zuluhed',
'\u0410\u0437\u0443\u0440\u0435\u0433\u043e\u0441','\u0411\u043e\u0440\u0435\u0439\u0441\u043a\u0430\u044f \u0442\u0443\u043d\u0434\u0440\u0430',
'\u0412\u0435\u0447\u043d\u0430\u044f \u041f\u0435\u0441\u043d\u044f','\u0413\u043e\u0440\u0434\u0443\u043d\u043d\u0438','\u0413\u0440\u043e\u043c',
'\u0414\u0440\u0430\u043a\u043e\u043d\u043e\u043c\u043e\u0440','\u041a\u043e\u0440\u043e\u043b\u044c-\u043b\u0438\u0447',
'\u041f\u0438\u0440\u0430\u0442\u0441\u043a\u0430\u044f \u0431\u0443\u0445\u0442\u0430','\u041f\u043e\u0434\u0437\u0435\u043c\u044c\u0435',
'\u0420\u0430\u0437\u0443\u0432\u0438\u0439','\u0421\u0432\u0435\u0436\u0435\u0432\u0430\u0442\u0435\u043b\u044c \u0414\u0443\u0448',
'\u0421\u0435\u0434\u043e\u0433\u0440\u0438\u0432','\u0421\u0442\u0440\u0430\u0436 \u0421\u043c\u0435\u0440\u0442\u0438',
'\u0422\u0435\u0440\u043c\u043e\u0448\u0442\u0435\u043f\u0441\u0435\u043b\u044c','\u0422\u043a\u0430\u0447 \u0421\u043c\u0435\u0440\u0442\u0438',
'\u042f\u0441\u0435\u043d\u0435\u0432\u044b\u0439 \u043b\u0435\u0441');

/* ----- US ----- */
$srvUS = array('Aegwynn','Aerie Peak','Agamaggan','Aggramar','Akama','Alexstrasza','Alleria','Altar of Storms','Alterac Mountains',
'Aman\'Thul','Andorhal','Anetheron','Antonidas','Anub\'arak','Anvilmar','Arathor','Archimonde','Area 52','Arena Tournament 1','Arena Tournament 2',
'Arena Tournament 3','Arena Tournament 4','Argent Dawn','Arthas','Arygos','Auchindoun','Azgalor',
'Azjol-Nerub','Azshara','Azuremyst','Baelgun','Balnazzar','Barthilas','Black Dragonflight','Blackhand','Blackrock','Blackwater Raiders','Blackwing Lair',
'Blade\'s Edge','Bladefist','Bleeding Hollow','Blood Furnace','Bloodhoof','Bloodscalp','Bonechewer','Borean Tundra','Boulderfist','Bronzebeard',
'Burning Blade','Burning Legion','Caelestrasz','Cairne','Cenarion Circle','Cenarius','Cho\'gall','Chromaggus','Coilfang',
'Coliseum 1','Crushridge','Daggerspine','Dalaran','Dalvengyr','Dark Iron','Darkspear','Darrowmere','Dath\'Remar','Dawnbringer','Deathwing',
'Demon Soul','Dentarg','Destromath','Dethecus','Detheroc','Doomhammer','Draenor','Dragonblight','Dragonmaw','Drak\'Tharon',
'Drak\'thul','Draka','Drakkari','Dreadmaul','Drenden','Dunemaul','Durotan','Duskwood','Earthen Ring','Echo Isles','Eitrigg','Eldre\'Thalas','Elune',
'Emerald Dream','Eonar','Eredar','Executus','Exodar','Farstriders','Feathermoon','Fenris','Firetree','Fizzcrank','Frostmane','Frostmourne','Frostwolf','Galakrond',
'Garithos','Garona','Garrosh','Ghostlands','Gilneas','Gnomeregan','Gorefiend','Gorgonnash','Greymane','Grizzly Hills',
'Gul\'dan','Gundrak','Gurubashi','Hakkar','Haomarush','Hellscream','Hydraxis','Hyjal','Icecrown','Illidan','Jaedenar','Jubei\'Thos',
'Kael\'thas','Kalecgos','Kargath','Kel\'Thuzad','Khadgar','Khaz Modan','Khaz\'goroth','Kil\'jaeden','Kilrogg','Kirin Tor','Korgath','Korialstrasz',
'Kul Tiras','Laughing Skull','Lethon','Lightbringer','Lightning\'s Blade','Lightninghoof','Llane','Lothar','Madoran','Maelstrom','Magtheridon','Maiev',
'Mal\'Ganis','Malfurion','Malorne','Malygos','Mannoroth','Medivh','Misha','Mok\'Nathal','Moon Guard','Moonrunner',
'Mug\'thol','Muradin','Nagrand','Nathrezim','Nazgrel','Nazjatar','Ner\'zhul','Nesingwary','Nordrassil','Norgannon','Onyxia','Perenolde','Proudmoore',
'Quel\'Thalas','Quel\'dorei','Ragnaros','Ravencrest','Ravenholdt','Rexxar','Rivendare','Runetotem','Sargeras','Saurfang','Scarlet Crusade','Scilla',
'Sen\'jin','Sentinels','Shadow Council','Shadowmoon','Shadowsong','Shandris','Shattered Halls','Shattered Hand','Shu\'halo','Silver Hand','Silvermoon',
'Sisters of Elune','Skullcrusher','Skywall','Smolderthorn','Spinebreaker','Spirestone','Staghelm','Steamwheedle Cartel',
'Stonemaul','Stormrage','Stormreaver','Stormscale','Suramar','Tanaris','Terenas','Terokkar','Thaurissan','The Forgotten Coast','The Scryers','The Underbog',
'The Venture Co','Thorium Brotherhood','Thrall','Thunderhorn','Thunderlord','Tichondrius','Tortheldrin','Trollbane','Turalyon',
'Twisting Nether','Uldaman','Uldum','Undermine','Ursin','Uther','Vashj','Vek\'nilash','Velen','Warsong','Whisperwind','Wildhammer','Windrunner','Winterhoof',
'Wyrmrest Accord','Ysera','Ysondre','Zangarmarsh','Zul\'jin','Zuluhed');

/* ----- KR ----- */
$srvKR = array('\uac00\ub85c\ub098','\uad74\ub2e8','\ub178\ub974\uac04\ub17c','\ub2ec\ub77c\ub780','\ub370\uc2a4\uc719','\ub4c0\ub85c\ud0c4',
'\ub77c\uadf8\ub098\ub85c\uc2a4','\ub808\uc778','\ub809\uc0ac\ub974','\ub9d0\ub9ac\uace0\uc2a4','\ub9d0\ud4e8\ub9ac\uc628','\uba54\ub514\ube0c',
'\ubd88\ud0c0\ub294 \uad70\ub2e8','\ube14\ub799\ubb34\uc5b4','\uc0b4\ud0c0\ub9ac\uc628','\uc138\ub098\ub9ac\uc6b0\uc2a4','\uc2a4\ud1b0\ub808\uc774\uc9c0',
'\uc544\ub808\ub098 \ud1a0\ub108\uba3c\ud2b8 1','\uc544\ub808\ub098 \ud1a0\ub108\uba3c\ud2b8 2','\uc544\ub808\ub098 \ud1a0\ub108\uba3c\ud2b8 3',
'\uc544\uc988\uc0e4\ub77c','\uc54c\ub77c\ub974','\uc54c\ub808\ub9ac\uc544','\uc54c\ub809\uc2a4\ud2b8\ub77c\uc790','\uc5d0\uc774\uadf8\uc708','\uc5d8\ub8ec',
'\uc640\uc77c\ub4dc\ud574\uba38','\uc6b0\uc11c','\uc6d0\ud615\uacbd\uae30\uc7a5 1','\uc708\ub4dc\ub7ec\ub108','\uc774\uc624\ub098','\uc904\uc9c4',
'\uce74\ub77c\uc794','\uce74\ub974\uac00\uc2a4','\ucfe8 \ud2f0\ub77c\uc2a4','\ud2f0\ub9ac\uc628','\ud3ed\ud48d\uc758 \ub208','\ud558\uc774\uc798',
'\ud5ec\uc2a4\ud06c\ub9bc');

/* ----CN ----- */
$srvCN = array('\u4e07\u8272\u661f\u8fb0','\u4e16\u754c\u4e4b\u6811','\u4e39\u83ab\u5fb7','\u4e3b\u5bb0\u4e4b\u5251','\u4e9a\u96f7\u6208\u65af',
'\u4f0a\u5170\u5c3c\u5e93\u65af','\u4f0a\u5229\u4e39','\u4f0a\u68ee\u5229\u6069','\u4f0a\u68ee\u5fb7\u96f7','\u4f0a\u745f\u62c9','\u4f0a\u83ab\u5854\u5c14',
'\u4f0a\u8428\u91cc\u5965\u65af','\u5143\u7d20\u4e4b\u529b','\u514b\u5c14\u82cf\u52a0\u5fb7','\u514b\u6d1b\u739b\u53e4\u65af','\u514b\u82cf\u6069',
'\u519b\u56e2\u8981\u585e','\u51ac\u6cc9\u8c37','\u51b0\u5ddd\u4e4b\u62f3','\u51b0\u971c\u4e4b\u5203','\u51b0\u98ce\u5c97','\u51e4\u51f0\u4e4b\u795e',
'\u51ef\u5c14\u8428\u65af','\u51ef\u6069\u8840\u8e44','\u5229\u5203\u4e4b\u62f3','\u523a\u9aa8\u5229\u5203','\u52a0\u5179\u9c81\u7ef4','\u52a0\u57fa\u68ee',
'\u52a0\u5c14','\u52a0\u5fb7\u7eb3\u5c14','\u52a0\u62c9\u5fb7\u5c14','\u52a0\u91cc\u7d22\u65af','\u52c7\u58eb\u5c9b','\u5339\u745e\u8bfa\u5fb7',
'\u5343\u9488\u77f3\u6797','\u5348\u591c\u4e4b\u9570','\u5361\u5fb7\u52a0','\u5361\u5fb7\u7f57\u65af','\u5361\u624e\u514b','\u5361\u62c9\u8d5e',
'\u5361\u73ca\u5fb7\u62c9','\u53e4\u52a0\u5c14','\u53e4\u5c14\u4e39','\u53e4\u62c9\u5df4\u4ec0','\u53e4\u96f7\u66fc\u683c','\u54c8\u5361',
'\u566c\u7075\u6cbc\u6cfd','\u56de\u97f3\u5c71','\u56fd\u738b\u4e4b\u8c37','\u56fe\u62c9\u626c','\u5723\u706b\u795e\u6bbf','\u5730\u72f1\u4e4b\u77f3',
'\u5730\u72f1\u5486\u54ee','\u57c3\u514b\u7d22\u56fe\u65af','\u57c3\u52a0\u6d1b\u5c14','\u57c3\u5fb7\u8428\u62c9','\u57c3\u82cf\u96f7\u683c',
'\u57c3\u96f7\u8fbe\u5c14','\u57fa\u5c14\u7f57\u683c','\u57fa\u723e\u52a0\u4e39','\u5854\u7eb3\u5229\u65af','\u585e\u62c9\u6469','\u585e\u62c9\u8d5e\u6069',
'\u585e\u6cf0\u514b','\u585e\u7eb3\u91cc\u5965','\u58c1\u7089\u8c37','\u590f\u7ef4\u5b89','\u5916\u57df','\u5927\u5730\u4e4b\u6012','\u5927\u6f29\u6da1',
'\u5929\u7a7a\u4e4b\u5899','\u592a\u9633\u4e4b\u4e95','\u593a\u7075\u8005','\u5948\u6cd5\u5229\u5b89','\u594e\u5c14\u8428\u62c9\u65af','\u5965\u4e39\u59c6',
'\u5965\u59ae\u514b\u5e0c\u4e9a','\u5965\u62c9\u57fa\u5c14','\u5965\u65af\u91cc\u5b89','\u5965\u7279\u5170\u514b','\u5965\u857e\u585e\u4e1d',
'\u5965\u857e\u8389\u4e9a','\u5965\u8fbe\u66fc','\u5b88\u62a4\u4e4b\u5251','\u5b89\u5176\u62c9','\u5b89\u591a\u54c8\u5c14','\u5b89\u5a01\u739b\u5c14',
'\u5b89\u6208\u6d1b','\u5b89\u7eb3\u585e\u9686','\u5b89\u82cf','\u5bc6\u6797\u6e38\u4fa0','\u5bd2\u51b0\u7687\u51a0','\u5bd2\u971c\u7687\u51a0',
'\u5c18\u98ce\u5ce1\u8c37','\u5c60\u9b54\u5c71\u8c37','\u5c71\u4e18\u4e4b\u738b','\u5ca9\u77f3\u5de8\u5854','\u5de8\u69cc','\u5de8\u9f99\u4e4b\u543c',
'\u5deb\u5996\u4e4b\u738b','\u5df4\u5c14\u53e4\u6069','\u5df4\u745f\u62c9\u65af','\u5df4\u7eb3\u624e\u5c14','\u5e03\u5170\u5361\u5fb7',
'\u5e03\u83b1\u514b\u6469','\u5e03\u83b1\u6069','\u5e03\u9c81\u5854\u5362\u65af','\u5e0c\u5c14\u74e6\u5a1c\u65af','\u5e0c\u96f7\u8bfa\u65af',
'\u5e7d\u6697\u6cbc\u6cfd','\u5e93\u5c14\u63d0\u62c9\u65af','\u5e93\u5fb7\u5170','\u5f17\u585e\u96f7\u8fe6','\u5f71\u7259\u8981\u585e','\u5fb7\u62c9\u8bfa',
'\u6000\u7279\u8fc8\u6069','\u6050\u6016\u56fe\u817e','\u6076\u9b54\u4e4b\u7ffc','\u6076\u9b54\u4e4b\u9b42','\u6208\u53e4\u7eb3\u65af','\u6208\u63d0\u514b',
'\u6208\u675c\u5c3c','\u6218\u6b4c','\u6234\u7d22\u59c6','\u624e\u62c9\u8d5e\u6069','\u6258\u585e\u5fb7\u6797','\u62c9\u6587\u51ef\u65af',
'\u62c9\u6587\u970d\u5fb7','\u62c9\u683c\u7eb3\u6d1b\u65af','\u62c9\u8d3e\u514b\u65af','\u63d0\u514b\u8fea\u5965\u65af','\u63d0\u5c14\u4e4b\u624b',
'\u63d0\u745e\u65af\u6cd5','\u6469\u6469\u5c14','\u65a9\u9b54\u8005','\u65af\u5766\u7d22\u59c6','\u65e0\u5c3d\u4e4b\u6d77','\u65e5\u843d\u6cbc\u6cfd',
'\u666e\u745e\u65af\u6258','\u666e\u7f57\u5fb7\u6469','\u6697\u5f71\u4e4b\u6708','\u6697\u5f71\u8bae\u4f1a','\u66ae\u8272\u68ee\u6797',
'\u66b4\u98ce\u796d\u575b','\u6708\u5149\u6797\u5730','\u6708\u795e\u6bbf','\u672b\u65e5\u884c\u8005','\u6735\u4e39\u5c3c\u5c14','\u675c\u9686\u5766',
'\u683c\u745e\u59c6\u5df4\u6258','\u683c\u96f7\u8fc8\u6069','\u683c\u9c81\u5c14','\u6851\u5fb7\u5170','\u6885\u5c14\u52a0\u5c3c','\u68a6\u5883\u4e4b\u6811',
'\u68ee\u91d1','\u6b7b\u4ea1\u4e4b\u7ffc','\u6b7b\u4ea1\u4e4b\u95e8','\u6b7b\u4ea1\u7194\u7089','\u6bc1\u706d\u4e4b\u9524','\u6c34\u6676\u4e4b\u523a',
'\u6c38\u591c\u6e2f','\u6c38\u6052\u4e4b\u4e95','\u6cd5\u62c9\u5e0c\u59c6','\u6cf0\u5170\u5fb7','\u6cf0\u5766\u4e4b\u62f3','\u6cf0\u62c9\u723e',
'\u6d1b\u4e39\u4f26','\u6d1b\u8428','\u6d77\u514b\u6cf0\u5c14','\u6d77\u52a0\u5c14','\u6d77\u8fbe\u5e0c\u4e9a','\u6d78\u6bd2\u4e4b\u9aa8',
'\u6df1\u6e0a\u4e4b\u5589','\u6df1\u6e0a\u4e4b\u5de2','\u6fc0\u6d41\u4e4b\u50b2','\u6fc0\u6d41\u5821','\u706b\u5589','\u706b\u70df\u4e4b\u8c37',
'\u706b\u7130\u4e4b\u5730','\u706b\u7130\u4e4b\u6811','\u706b\u7fbd\u5c71','\u7070\u70ec\u4f7f\u8005','\u7070\u8c37','\u70c8\u7130\u5cf0',
'\u70c8\u7130\u8346\u68d8','\u718a\u732b\u9152\u4ed9','\u7194\u706b\u4e4b\u5fc3','\u71b5\u9b54','\u71c3\u70e7\u4e4b\u5203','\u71c3\u70e7\u519b\u56e2',
'\u71c3\u70e7\u5e73\u539f','\u7231\u65af\u7279\u7eb3','\u72c2\u70ed\u4e4b\u5203','\u72c2\u98ce\u5ced\u58c1','\u739b\u52a0\u8428','\u739b\u591a\u5170',
'\u739b\u683c\u7d22\u5c14','\u739b\u6cd5\u91cc\u5965','\u739b\u745f\u91cc\u987f','\u739b\u8bfa\u6d1b\u65af','\u739b\u91cc\u82df\u65af',
'\u745e\u6587\u6234\u5c14','\u745f\u739b\u666e\u62c9\u683c','\u745f\u83b1\u5fb7\u4e1d','\u74e6\u62c9\u65af\u5854\u5179','\u74e6\u91cc\u739b\u8428\u65af',
'\u751c\u6c34\u7eff\u6d32','\u751f\u6001\u8239','\u767d\u94f6\u4e4b\u624b','\u767d\u9aa8\u8352\u91ce','\u76d6\u65af','\u77f3\u722a\u5cf0',
'\u77f3\u9524','\u7834\u788e\u4e4b\u624b','\u7834\u788e\u5927\u5385','\u7834\u788e\u5cad','\u788e\u88c2\u4e4b\u62f3','\u788e\u9885\u8005',
'\u7956\u5c14\u91d1','\u7956\u963f\u66fc','\u7956\u9c81\u5e0c\u5fb7','\u795e\u5723\u4e4b\u6b4c','\u7981\u9b54\u76d1\u72f1','\u7b26\u6587\u56fe\u817e',
'\u7c73\u5948\u5e0c\u5c14','\u7d22\u62c9\u4e01','\u7d22\u745e\u68ee','\u7ea2\u4e91\u53f0\u5730','\u7ea2\u9f99\u519b\u56e2','\u7ea2\u9f99\u5973\u738b',
'\u7eb3\u514b\u8428\u739b\u65af','\u7eb3\u6c99\u5854\u5c14','\u7ef4\u514b\u5c3c\u62c9\u65af','\u7ef4\u514b\u6d1b\u5c14','\u7f57\u5b81','\u7fbd\u6708',
'\u7fe1\u7fe0\u68a6\u5883','\u8010\u514b\u9c81\u65af','\u8010\u5965\u7956','\u8010\u666e\u56fe\u9686','\u8010\u8428\u91cc\u5965','\u8033\u8bed\u6d77\u5cb8',
'\u80fd\u6e90\u8230','\u81ea\u7531\u4e4b\u98ce','\u827e\u68ee\u5a1c','\u827e\u6b27\u7eb3\u5c14','\u827e\u7ef4\u5a1c','\u827e\u82cf\u6069',
'\u827e\u83ab\u8389\u4e1d','\u827e\u8428\u62c9','\u827e\u9686\u7eb3\u4e9a','\u82ac\u91cc\u65af','\u82cf\u5854\u6069','\u8303\u514b\u91cc\u592b',
'\u8303\u8fbe\u5c14\u9e7f\u76d4','\u8346\u68d8\u8c37','\u83ab\u4ec0\u5965\u683c','\u83ab\u5fb7\u53e4\u5f97','\u83ab\u683c\u83b1\u5c3c',
'\u83b1\u65af\u971c\u8bed','\u83b1\u7d22\u6069','\u83f2\u62c9\u65af','\u8428\u5c14','\u8428\u683c\u62c9\u65af','\u8428\u83f2\u9686',
'\u84dd\u9f99\u519b\u56e2','\u85cf\u5b9d\u6d77\u6e7e','\u8718\u86db\u738b\u56fd','\u8840\u543c','\u8840\u69cc','\u8840\u7259\u9b54\u738b','\u8840\u73af',
'\u8840\u7fbd','\u8840\u8272\u5341\u5b57\u519b','\u8840\u9876','\u8bd5\u70bc\u4e4b\u73af','\u8bfa\u5179\u591a\u59c6','\u8bfa\u68ee\u5fb7',
'\u8bfa\u83ab\u745e\u6839','\u8d2b\u7620\u4e4b\u5730','\u8e0f\u68a6\u8005','\u8f7b\u98ce\u4e4b\u8bed','\u8fbe\u5361\u5c3c','\u8fbe\u57fa\u8428\u65af',
'\u8fbe\u5c14\u574e','\u8fbe\u6587\u683c\u5c14','\u8fbe\u65af\u96f7\u739b','\u8fbe\u7eb3\u65af','\u8fbe\u9686\u7c73\u5c14','\u8fc5\u6377\u5fae\u98ce',
'\u8fe6\u739b\u5170','\u8fe6\u7f57\u5a1c','\u8fe6\u987f','\u8fea\u5854\u683c','\u8fea\u6258\u9a6c\u65af','\u8fea\u745f\u6d1b\u514b',
'\u8fea\u95e8\u4fee\u65af','\u8ff7\u96fe\u4e4b\u6d77','\u9010\u65e5\u8005','\u901a\u7075\u5b66\u9662','\u9057\u5fd8\u6d77\u5cb8','\u90aa\u6076\u9885\u58f3',
'\u90aa\u679d','\u91d1\u5ea6','\u91d1\u8272\u5e73\u539f','\u94dc\u9f99\u519b\u56e2','\u94f6\u6708','\u94f6\u677e\u68ee\u6797','\u95ea\u7535\u4e4b\u5203',
'\u9634\u5f71\u4e4b\u523a','\u963f\u514b\u8499\u5fb7','\u963f\u52aa\u5df4\u62c9\u514b','\u963f\u5361\u739b','\u963f\u53e4\u65af','\u963f\u5c14\u8428\u65af',
'\u963f\u624e\u8fbe\u65af','\u963f\u62c9\u5e0c','\u963f\u62c9\u7d22','\u963f\u65af\u5854\u6d1b','\u963f\u66fc\u5c3c','\u963f\u683c\u62c9\u739b',
'\u963f\u6bd4\u8fea\u65af','\u963f\u7eb3\u514b\u6d1b\u65af','\u963f\u8fe6\u739b\u7518','\u96cf\u9f99\u4e4b\u7ffc','\u96f7\u514b\u8428','\u96f7\u5fb7',
'\u96f7\u65a7\u5821\u5792','\u96f7\u9706\u4e4b\u6012','\u96f7\u9706\u4e4b\u738b','\u96f7\u9706\u53f7\u89d2','\u971c\u4e4b\u54c0\u4f24','\u971c\u72fc',
'\u98ce\u66b4\u4e4b\u6012','\u98ce\u66b4\u4e4b\u773c','\u98ce\u66b4\u4e4b\u9cde','\u98ce\u66b4\u88c2\u9699','\u98ce\u66b4\u8981\u585e','\u98ce\u884c\u8005',
'\u9b3c\u96fe\u5cf0','\u9c9c\u8840\u4e4b\u73af','\u9c9c\u8840\u7194\u7089','\u9e70\u5de2\u5c71','\u9ea6\u7ef4\u5f71\u6b4c','\u9ea6\u8fea\u6587',
'\u9ec4\u91d1\u4e4b\u8def','\u9ed1\u624b\u519b\u56e2','\u9ed1\u6697\u4e4b\u77db','\u9ed1\u6697\u4e4b\u95e8','\u9ed1\u6697\u865a\u7a7a',
'\u9ed1\u6697\u9b45\u5f71','\u9ed1\u77f3\u5c16\u5854','\u9ed1\u7ffc\u4e4b\u5de2','\u9ed1\u94c1','\u9ed1\u9f99\u519b\u56e2','\u9f99\u9aa8\u5e73\u539f');

/* ----- TW ----- */
$srvTW = array('\u4e16\u754c\u4e4b\u6a39','\u4e9e\u96f7\u6208\u65af','\u5168\u7403\u722d\u9738\u62301','\u5168\u7403\u722d\u9738\u62302',
'\u5168\u7403\u722d\u9738\u62303','\u51b0\u971c\u4e4b\u523a','\u51b0\u98a8\u5d17\u54e8','\u5730\u7344\u543c','\u591c\u7a7a\u4e4b\u6b4c',
'\u5927\u7af6\u6280\u58341','\u5929\u7a7a\u4e4b\u7246','\u5967\u59ae\u514b\u5e0c\u4e9e','\u5bd2\u51b0\u7687\u51a0','\u5c16\u77f3','\u5c60\u9b54\u5c71\u8c37',
'\u5de8\u9f8d\u4e4b\u5589','\u5df4\u7d0d\u672d\u723e','\u61a4\u6012\u4f7f\u8005','\u6230\u6b4c','\u65e5\u843d\u6cbc\u6fa4','\u6697\u5f71\u4e4b\u6708',
'\u66b4\u98a8\u796d\u58c7','\u6c34\u6676\u4e4b\u523a','\u72c2\u71b1\u4e4b\u5203','\u773e\u661f\u4e4b\u5b50','\u7c73\u5948\u5e0c\u723e',
'\u8056\u5149\u4e4b\u9858','\u8840\u4e4b\u8c37','\u8840\u9802\u90e8\u65cf','\u8a9e\u98a8','\u8afe\u59c6\u745e\u6839','\u9280\u7ffc\u8981\u585e',
'\u963f\u85a9\u65af','\u96f7\u9c57','\u971c\u4e4b\u54c0\u50b7','\u9b3c\u9727\u5cf0');

$mysql = new hfw_mysql($config);

for($t=0;$t<count($srvUE);$t++)
{
	$mysql->query("INSERT INTO srv VALUES('','EU','".str_replace('\'','\\\'',$srvUE[$t])."')");
}
for($t=0;$t<count($srvUS);$t++)
{
	$mysql->query("INSERT INTO srv VALUES('','US','".str_replace('\'','\\\'',$srvUS[$t])."')");
}
for($t=0;$t<count($srvKR);$t++)
{
	$mysql->query("INSERT INTO srv VALUES('','KR','".str_replace('\\','\\\\',$srvKR[$t])."')");
}for($t=0;$t<count($srvCN);$t++)
{
	$mysql->query("INSERT INTO srv VALUES('','CN','".str_replace('\\','\\\\',$srvCN[$t])."')");
}
for($t=0;$t<count($srvTW);$t++)
{
	$mysql->query("INSERT INTO srv VALUES('','TW','".str_replace('\\','\\\\',$srvTW[$t])."')");
}

echo 'ok';



?>
