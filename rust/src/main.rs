use std::fs;
use std::io;
use std::path::Path;

fn fetch(path: &str, file_type: &str, recursion: bool) -> io::Result<()> {
    let path = Path::new(path);

    if !path.exists() {
        return Err(io::Error::new(io::ErrorKind::NotFound, "No directory found at path"));
    }

    validate_path(&path)?;

    process(&path, file_type, recursion)
}

fn validate_path(path: &Path) -> io::Result<()> {
    if !path.is_dir() {
        return Err(io::Error::new(io::ErrorKind::InvalidInput, "Invalid directory"));
    }

    Ok(())
}

fn process(path: &Path, file_type: &str, recursion: bool) -> io::Result<()> {
    for entry in fs::read_dir(path)? {
        let entry = entry?;

        let entry_path = entry.path();
        let entry_file_type = if entry_path.is_dir() {
            "dir"
        } else {
            "file"
        };

        if file_type == "both" || file_type == entry_file_type {
            println!("Filename: {:?}", entry.file_name());
            println!("Filepath: {:?}", entry_path.display());
            println!("--------------------------");
        }

        if recursion && entry_path.is_dir() {
            process(&entry_path, file_type, recursion)?;
        }
    }

    Ok(())
}

fn main() {
    if let Err(err) = fetch("..", "both", false) {
        eprintln!("Error: {}", err);
    }
}
