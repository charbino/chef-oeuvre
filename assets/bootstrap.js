import { startStimulusApp } from '@symfony/stimulus-bridge';
import LiveController from "@symfony/ux-live-component"

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

app.register('live', LiveController);
import '@symfony/ux-live-component/styles/live.css';