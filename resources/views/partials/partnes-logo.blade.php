<style>
    .infopartners {
        display: flex;
        justify-content: start;
        align-items: start;
        gap: 20px;
        /* spacing between logos */
        flex-wrap: wrap;
        /* optional: allows wrapping on smaller screens */
    }

 


    .infopartners img {
        height: 40px;
        width: 50px;
        object-fit: contain;
    }

       /* Styles for desktop view only */
    @media screen and (min-width: 1024px) {
        .infopartners {
            padding-left: 120px;
        display: flex;
        justify-content: start;
        align-items: start;
        gap: 20px;
        /* spacing between logos */
        flex-wrap: wrap;
        /* optional: allows wrapping on smaller screens */
    }
    }
</style>

<div class="infopartners">
    <img src="{{ asset('partnes/fsjes.jpg') }}" width="50" height="40" alt="FSJES">
    <img src="{{ asset('partnes/massir.jpg') }}" width="50" height="40" alt="Massir">
    <img src="{{ asset('partnes/uhc.jpg') }}" width="50" height="40" alt="UHC">
    <img src="{{ asset('partnes/uh1.jpg') }}" width="50" height="40" alt="UH1">
    <img src="{{ asset('partnes/srd.jpg') }}" width="50" height="40" alt="SRD">
    <img src="{{ asset('partnes/scopus.jpg') }}" width="50" height="40" alt="Scopus">
    <img src="{{ asset('partnes/springer.jpg') }}" width="50" height="40" alt="Springer">
</div>
