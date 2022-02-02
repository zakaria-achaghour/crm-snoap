<H3>Bonjour</H3>

<h3>{{ 'Une rupture des articles suivent a été détéctée à la pharmacie : '. $ruptures[0]->nom .'  par : '. $ruptures[0]->firstname .' '. $ruptures[0]->lastname .'  le: '. \Carbon\Carbon::parse($ruptures[0]->created_at)->format('d/m/Y') }}</h3>

<h4>Les articles sont: </h4>

<ol>
    @foreach ($ruptures as $rupture)
        <li>
            {{ ($rupture->autre==1)? $rupture->product : $rupture->designation }}
        </li>

    @endforeach
</ol>   

Cordialement
