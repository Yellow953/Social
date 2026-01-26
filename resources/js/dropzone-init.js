import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

// Make Dropzone available globally for Blade templates
window.Dropzone = Dropzone;

// Auto-disable discovery
Dropzone.autoDiscover = false;

// Export for use in other modules if needed
export default Dropzone;
