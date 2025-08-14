import { BrowserRouter } from "react-router-dom";
import AppRouter from "./routes/AppRouter";
import { Toaster } from "sonner";

function App() {
  return (
    <BrowserRouter>
      {/* toaser untuk notifikasi/alert */}
      <Toaster position="bottom-right" richColors closeButton duration={4000} />
      <AppRouter />
    </BrowserRouter>
  );
}

export default App;
