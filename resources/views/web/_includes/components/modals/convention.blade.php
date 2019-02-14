<form id="convention" class="modal fade" tabindex="-1" action="{{ $route }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Données des convention
            </div>

            <div class="modal-body text-center">
                <p>
                    Souhaitez vous les conventions : <br>
                </p>

                <div class="custom-checkbox">
                    <input id="etablissement" name="etablissement" type="checkbox" value="true" checked>
                    <label for="etablissement">Avec l'établissement et la classe pré-remplie</label>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-dark" type="button" data-dismiss="modal">Annuler</button>
                    <button id="submit" class="btn btn-primary" type="submit" formtarget="_blank">Générer</button>
                </div>
            </div>
        </div>
    </div>
</form>