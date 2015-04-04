<?php
namespace LibraryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LibraryBundle\Entity\Book;
use LibraryBundle\Entity\Category;
use LibraryBundle\Entity\Status;

class LoadBookData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $book1 = new Book();
        $book1->setTitle('Moteris narve');
        $book1->setAuthor('Jussi Adler-Olsen');
        $book1->setPublisher('Obuolys');
        $book1->setDescription('Iš pradžių ji drasko sienas, kol susikruvina pirštus. Aklina tamsa, nė vieno daikto. Iš kambario nėra vilties pasprukti. Nėra pagal ką skaičiuoti laiką, dienas, savaites, metus. Bet ji prisiekia sau neišprotėti. Ji nesuteiks pagrobėjams pasitenkinimo anksčiau, nei ją užklups mirtis.');
        $book1->setPages('464');
        $book1->setCreatedAt(new \DateTime());
        $book1->setCategory($this->getReference('category1'));

        $book2 = new Book();
        $book2->setTitle('Kačių stalas');
        $book2->setAuthor('Michael Ondaatje');
        $book2->setPublisher('Tyto Alba');
        $book2->setDescription('Ar ne todėl, taip nieko galutinai ir nesupratę, likome sėdėti prie „kačių stalo“, vis žvilgčiodami ir dairydamiesi atgal, net dabar, mūsų amžiuje, ieškodami tų, su kuriais keliavome ir kurie sukūrė mus tokius, kokie esame.');
        $book2->setPages('264');
        $book2->setCreatedAt(new \DateTime());
        $book2->setCategory($this->getReference('category2'));

        $book3 = new Book();
        $book3->setTitle('Namas prie jūros');
        $book3->setAuthor('Santa Montefiore');
        $book3->setPublisher('Alma littera');
        $book3->setDescription('1966-ieji, Italija. Toskanoje gyvenanti iš skurdžios šeimos kilusi mergaičiukė Floriana nuo vaikystės mėgdavo slapčia apžiūrinėti prie jūros stūksančią nuostabaus grožio vilą ir svajodavo, kad kada nors ištrūks iš savo pasaulėlio ir apsigyvens čionai. Vieną dieną prie vartų ją užklumpa daug vyresnis vilos savininkų sūnus Dantė. Jaunuolis pakviečia Florianą užeiti, ir nuo tos akimirkos mergaitė neabejoja – jiedviem lemta būti kartu.');
        $book3->setPages('440');
        $book3->setCreatedAt(new \DateTime());
        $book3->setCategory($this->getReference('category2'));

        $book4 = new Book();
        $book4->setTitle('Mėnulio vaivorykštė');
        $book4->setAuthor('Tomas Šinkariukas');
        $book4->setPublisher('Kitos knygos');
        $book4->setDescription('Kaune gyvenantis dramaturgas ir prozininkas Tomas Šinkariukas (g. 1971) – turbūt pati paslaptingiausia figūra šiuolaikinėje lietuvių literatūroje. Jis neduoda interviu, nesifotografuoja, nedalyvauja literatūriniame gyvenime, nerengia savo kūrybos skaitymų. Ramioje vienatvėje jis kuria tamsius ir keistus tekstus apie buities pragarą ir iš jo išvaduojančią fatališką kelionę į mirtį.');
        $book4->setPages('288');
        $book4->setCreatedAt(new \DateTime());
        $book4->setCategory($this->getReference('category3'));

        $book5 = new Book();
        $book5->setTitle('Anarchizmas ir kitos esė');
        $book5->setAuthor('Emma Goldman');
        $book5->setPublisher('Kitos knygos');
        $book5->setDescription('1869 metais Kaune, Vilijampolėje, gimė pavojingiausia Amerikos moteris. Taip amerikiečių saugumo tarnybos vadino Jungtinėse Valstijose anarchizmo ikona tapusią Emmą Goldman (1869–1940). „Anarchizmas ir kitos esė“ yra pirmoji jos knyga ir iki šiol laikoma socialinės kritikos klasika. Prieš šimtmetį parašyti tekstai stulbina plačiu akiračiu ir užkrečia idealizmu. Goldman ateities vizijoje individui nebereikės valdžios, kalėjimai nežlugdys žmonių, moterys nebebus antrarūšės, menas sieks radikalumo, alternatyvus švietimas taps vertybe, o meilei nebereikės santuokos. Ši knyga paneigia daugybę su anarchizmu siejamų prietarų ir atiduoda duoklę legendinei litvakų kilmės asmenybei.');
        $book5->setPages('192');
        $book5->setCreatedAt(new \DateTime());
        $book5->setCategory($this->getReference('category4'));

        $manager->persist($book1);
        $manager->persist($book2);
        $manager->persist($book3);
        $manager->persist($book4);
        $manager->persist($book5);
        $manager->flush();

   }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}