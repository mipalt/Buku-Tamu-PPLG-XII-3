import { Route, Routes } from "react-router-dom";
import Dashboard from "./pages/dashboard";
import Parent from "./pages/all-data/parent";
import Alumni from "./pages/all-data/alumni";
import Layout from "./layouts/Layout";
import Detail from "./pages/all-data/detail";

function App() {
  return (
    <Routes>
      <Route path="/" Component={Layout}>
        <Route path="/" Component={Dashboard} />
        <Route path="/parent" Component={Parent} />
        <Route path="/alumni" Component={Alumni} />
        <Route path="/detail" Component={Detail} />
      </Route>
    </Routes>
  );
}

export default App;
