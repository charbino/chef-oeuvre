import {Controller} from '@hotwired/stimulus';
import libEventSource from 'event-source-polyfill';

export default class extends Controller {
    static values = {topic: String}

    static targets = ["mercureContainer"]

    connect() {
        const token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.a8cjcSRUAcHdnGNMKifA4BK5epRXxQI0UBp2XpNrBdw";
        const url = `http://127.0.0.1:3001/.well-known/mercure?topic=/fr/this-is-topic`;

        const eventSource = new libEventSource.EventSourcePolyfill(url, {
            headers: {
                'Authorization': 'Bearer ' + token,
            }
        });

        eventSource.onmessage = (event) => {
            let data = JSON.parse(event.data);
            this.displayMessage(data);
        };

        eventSource.onerror = (error) => {
            this.displayError(error);
        };
    }

    displayMessage(data) {
        this.mercureContainerTarget.innerHTML = `
        <div class="card">
        <div class="card-header">
        <div class="card-header-title">
         ${new Date().toLocaleTimeString()}
        </div>
        </div>
          <div class="card-content">
            <div class="content">
             ${data.message}
            </div>
          </div>
        </div>
        ` + this.mercureContainerTarget.innerHTML;
    }

    displayError(message) {
        console.error("Erreur Mercure :", message);
    }
}
