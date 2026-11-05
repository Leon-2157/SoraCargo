# WhatsApp Gateway Service (In-House Private Service)

Slot direktori untuk meletakkan source code project WhatsApp Gateway pribadi Anda (`/home/leon/Documents/Project/wa-gateway`).

- **Peran Jaringan**: Internal Microservice (Hanya dapat diakses antar-container Podman via `http://wa-gateway:3000`).
- **Akses Pengelolaan**: Dikelola secara eksklusif oleh Admin (`apps/admin`) untuk pairing QR Code, session status, dan logs.
- **Konsumen Pesan**: Digunakan oleh `apps/customer` (notifikasi otomatis resi kargo) dan `apps/operator` (koordinasi lapangan & eskalasi).

