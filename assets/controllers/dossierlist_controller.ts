import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  // Déclaration des targets pour Stimulus
  static targets = ['details'];

  // Déclaration pour TypeScript (permet l'autocomplétion)
  // On utilise "declare" pour dire à TS que Stimulus va injecter cette propriété
  declare readonly detailsTarget: HTMLElement;

  async getDetails(event: any) {
    const id = event.currentTarget.getAttribute('data-id');

    // Il est préférable d'utiliser currentTarget pour être sûr
    // de cibler l'élément qui porte le data-id
    const response = await fetch(`/dossier/ajax/details/${id}`);

    if (response.ok) {
      this.detailsTarget.innerHTML = await response.text();
    }
  }
}